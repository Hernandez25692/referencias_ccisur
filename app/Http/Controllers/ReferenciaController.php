<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Bitacora;


class ReferenciaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $rol = $user->getRoleNames()->first();

        $query = Referencia::where('departamento', $rol);

        // Filtro búsqueda
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('correlativo', 'like', '%' . $request->search . '%')
                    ->orWhere('asunto', 'like', '%' . $request->search . '%')
                    ->orWhere('solicitado_por', 'like', '%' . $request->search . '%')
                    ->orWhere('autorizado_por', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // ✅ Filtro año
        if ($request->filled('anio')) {
            $query->whereYear('created_at', $request->anio);
        }

        // Obtener años únicos para el select (solo del departamento actual)
        $aniosDisponibles = Referencia::where('departamento', $rol)
            ->selectRaw('YEAR(created_at) as anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        // Paginación dinámica
        $perPage = $request->input('per_page', 30);
        $referencias = $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->appends($request->query());

        return view('referencias.index', compact('referencias', 'aniosDisponibles'));
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
        $departamento = $user->getRoleNames()->first();
        $año = date('Y');

        $inicioDelAño = Carbon::create(date('Y'), 1, 1);
        $finDelAño = Carbon::create(date('Y'), 12, 31, 23, 59, 59);

        $ultimo = Referencia::where('departamento', $departamento)
            ->whereBetween('created_at', [$inicioDelAño, $finDelAño])
            ->count() + 1;

        $correlativoNum = $departamento . '-' . $año . '-' . str_pad($ultimo, 3, '0', STR_PAD_LEFT);
        $correlativo = 'REF-CCISUR/' . $correlativoNum;


        $rutaDocumento = null;
        $nombreArchivoFinal = null;

        if ($request->hasFile('documento')) {
            $archivo = $request->file('documento');
            $extension = $archivo->getClientOriginalExtension();
            $nombreLimpio = preg_replace('/[^a-zA-Z0-9_-]/', '', Str::slug($request->asunto));
            $nombreArchivoFinal = 'REF-CCISUR-' . $correlativoNum . '-' . $nombreLimpio . '.' . $extension;


            $rutaDocumento = $archivo->storeAs('documentos', $nombreArchivoFinal, 'public');

            // Copiar a carpeta compartida GENERAL
            $carpetaDestino = "/mnt/referencias/REFSIS/{$departamento}/";

            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $origen = storage_path("app/public/{$rutaDocumento}");
            $destino = "{$carpetaDestino}/{$nombreArchivoFinal}";

            try {
                copy($origen, $destino);
            } catch (\Exception $e) {
                \Log::error("Error copiando a carpeta compartida: " . $e->getMessage());
            }
        }

        $estado = ($request->filled(['asunto', 'solicitado_por', 'autorizado_por']) && $rutaDocumento) ? 'completo' : 'pendiente';

        $referencia = Referencia::create([
            'correlativo' => $correlativo,
            'asunto' => $request->asunto,
            'solicitado_por' => $request->solicitado_por,
            'autorizado_por' => $request->autorizado_por,
            'documento' => $rutaDocumento,
            'departamento' => $departamento,
            'estado' => $estado,
            'user_id' => $user->id,
        ]);

        Bitacora::create([
            'referencia_id' => $referencia->id,
            'accion' => 'creado',
            'cambios' => 'Referencia registrada con correlativo: ' . $correlativo,
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

        $user = Auth::user();
        $cambios = [];

        if ($referencia->asunto !== $request->asunto) {
            $cambios[] = "Asunto: '{$referencia->asunto}' → '{$request->asunto}'";
            $referencia->asunto = $request->asunto;
        }

        if ($referencia->solicitado_por !== $request->solicitado_por) {
            $cambios[] = "Solicitado por: '{$referencia->solicitado_por}' → '{$request->solicitado_por}'";
            $referencia->solicitado_por = $request->solicitado_por;
        }

        if ($referencia->autorizado_por !== $request->autorizado_por) {
            $cambios[] = "Autorizado por: '{$referencia->autorizado_por}' → '{$request->autorizado_por}'";
            $referencia->autorizado_por = $request->autorizado_por;
        }

        if ($request->hasFile('documento')) {
            $archivo = $request->file('documento');
            $extension = $archivo->getClientOriginalExtension();
            $nombreLimpio = preg_replace('/[^a-zA-Z0-9_-]/', '', Str::slug($request->asunto));

            $correlativoPlano = str_replace('/', '-', $referencia->correlativo); // <-- este es el fix clave
            $nombreArchivoFinal = $correlativoPlano . '-' . $nombreLimpio . '.' . $extension;

            $rutaDocumento = $archivo->storeAs('documentos', $nombreArchivoFinal, 'public');

            $carpetaDestino = "/mnt/referencias/REFSIS/{$referencia->departamento}/";

            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $origen = storage_path("app/public/{$rutaDocumento}");
            $destino = "{$carpetaDestino}/{$nombreArchivoFinal}";

            try {
                copy($origen, $destino);
            } catch (\Exception $e) {
                \Log::error("Error copiando archivo actualizado: " . $e->getMessage());
            }

            $cambios[] = "Documento actualizado: {$nombreArchivoFinal}";
            $referencia->documento = $rutaDocumento;
        }


        $estadoAnterior = $referencia->estado;
        $referencia->estado = ($referencia->asunto && $referencia->solicitado_por && $referencia->autorizado_por && $referencia->documento) ? 'completo' : 'pendiente';

        if ($referencia->estado !== $estadoAnterior) {
            $cambios[] = "Estado: '{$estadoAnterior}' → '{$referencia->estado}'";
        }

        $referencia->save();

        if (!empty($cambios)) {
            Bitacora::create([
                'referencia_id' => $referencia->id,
                'accion' => 'actualizado',
                'cambios' => implode(' | ', $cambios),
                'user_id' => $user->id,
            ]);
        }

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

        // ✅ Filtro por año
        if ($request->filled('anio')) {
            $query->whereYear('created_at', $request->anio);
        }

        // ✅ Obtener todos los años disponibles
        $aniosDisponibles = Referencia::selectRaw('YEAR(created_at) as anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        $perPage = $request->input('per_page', 20); // por defecto 20
        $referencias = $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->appends($request->query());


        $departamentos = Referencia::select('departamento')->distinct()->pluck('departamento');

        return view('referencias.admin_index', compact('referencias', 'departamentos', 'aniosDisponibles'));
    }




    public function show(Referencia $referencia)
    {
        return view('referencias.show', compact('referencia'));
    }

    //solo para SuperAdmin
    public function bitacora(Referencia $referencia)
    {
        $referencia->load(['bitacoras.user']);

        return view('referencias.bitacora', compact('referencia'));
    }
}
