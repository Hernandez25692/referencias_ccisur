<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReferenciaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $rol = $user->getRoleNames()->first();

        $query = Referencia::where('departamento', $rol);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('correlativo', 'like', '%' . $request->search . '%')
                    ->orWhere('asunto', 'like', '%' . $request->search . '%')
                    ->orWhere('solicitado_por', 'like', '%' . $request->search . '%')
                    ->orWhere('autorizado_por', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $referencias = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        return view('referencias.index', compact('referencias'));
    }



    public function create()
    {
        return view('referencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'nullable|string',
            'solicitado_por' => 'nullable|string',
            'autorizado_por' => 'nullable|string',
            'documento' => 'nullable|file|mimes:pdf,docx,doc,jpg,png|max:2048',
        ]);

        $user = Auth::user();
        $departamento = $user->getRoleNames()->first(); // GAF, GOR, etc.
        $año = date('Y');

        // Obtener el último correlativo
        $ultimo = Referencia::where('departamento', $departamento)
            ->whereYear('created_at', $año)
            ->count() + 1;

        $correlativo = 'REF-CCISUR/' . $departamento . '-' . $año . '-' . str_pad($ultimo, 3, '0', STR_PAD_LEFT);

        $rutaDocumento = null;
        if ($request->hasFile('documento')) {
            $rutaDocumento = $request->file('documento')->store('documentos', 'public');
        }

        Referencia::create([
            'correlativo' => $correlativo,
            'asunto' => $request->asunto,
            'solicitado_por' => $request->solicitado_por,
            'autorizado_por' => $request->autorizado_por,
            'documento' => $rutaDocumento,
            'departamento' => $departamento,
            'estado' => $request->filled('asunto', 'documento', 'autorizado_por', 'solicitado_por') && $request->hasFile('documento') ? 'completo' : 'pendiente',
            'user_id' => $user->id,
        ]);

        return redirect()->route('referencias.index')->with('success', '✅ REFSIS: La referencia fue registrada exitosamente y está disponible en el sistema.');
    }

    public function edit(Referencia $referencia)
    {
        // Asegura que solo el dueño o el mismo departamento pueda editar
        if (Auth::user()->getRoleNames()->first() !== $referencia->departamento) {
            abort(403, 'No autorizado');
        }

        return view('referencias.edit', compact('referencia'));
    }

    public function update(Request $request, Referencia $referencia)
    {
        $request->validate([
            'asunto' => 'nullable|string',
            'solicitado_por' => 'nullable|string',
            'autorizado_por' => 'nullable|string',
            'documento' => 'nullable|file|mimes:pdf,docx,doc,jpg,png|max:2048',
        ]);

        if ($request->hasFile('documento')) {
            $rutaDocumento = $request->file('documento')->store('documentos', 'public');
            $referencia->documento = $rutaDocumento;
        }

        $referencia->asunto = $request->asunto;
        $referencia->solicitado_por = $request->solicitado_por;
        $referencia->autorizado_por = $request->autorizado_por;

        $referencia->estado = $referencia->asunto && $referencia->documento ? 'completo' : 'pendiente';
        $referencia->save();

        return redirect()->route('referencias.index')->with('success', 'Referencia actualizada.');
    }

    public function adminIndex()
    {
        $referencias = \App\Models\Referencia::with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('referencias.admin_index', compact('referencias'));
    }

    public function show(Referencia $referencia)
    {
        return view('referencias.show', compact('referencia'));
    }
}
