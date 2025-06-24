<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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

        $referencias = $query->orderByRaw('created_at DESC')->paginate(10)->appends($request->query());


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
        $inicioDelAño = Carbon::create(date('Y'), 1, 1, 0, 0, 0, 'UTC');
        $finDelAño = Carbon::create(date('Y'), 12, 31, 23, 59, 59, 'UTC');

        $ultimo = Referencia::where('departamento', $departamento)
            ->whereBetween('created_at', [$inicioDelAño, $finDelAño])
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

        return redirect()->route('referencias.index')->with('success', 'La referencia fue registrada exitosamente y está disponible en el sistema.');
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

        return redirect()->route('referencias.index')->with('success', 'Los datos de la referencia han sido actualizados con éxito.');
    }

    public function adminIndex(Request $request)
    {
        $query = Referencia::with('user');

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

        if ($request->filled('departamento')) {
            $query->where('departamento', $request->departamento);
        }

        $referencias = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        // Lista única de departamentos para el select
        $departamentos = Referencia::select('departamento')->distinct()->pluck('departamento');

        return view('referencias.admin_index', compact('referencias', 'departamentos'));
    }



    public function show(Referencia $referencia)
    {
        return view('referencias.show', compact('referencia'));
    }
}
