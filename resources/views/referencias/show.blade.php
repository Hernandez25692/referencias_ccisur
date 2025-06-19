@extends('layouts.app')

@section('breadcrumbs')
    <li aria-current="page">
        <div class="flex items-center">
            <i class="ph ph-arrow-right text-gray-400 mr-2"></i>
            <span class="text-sm font-medium text-gray-500">Detalle de Referencia</span>
        </div>
    </li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-md p-6 animate__animated animate__fadeIn">
        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <div>
                <h2 class="text-2xl font-bold text-[#002c5f] flex items-center gap-2">
                    <i class="ph ph-file-text"></i> Detalle de Referencia
                </h2>
                <p class="text-sm text-gray-600">Información detallada del documento generado</p>
            </div>
            @role('SuperAdmin')
                <a href="{{ url('/referencias/admin') }}"
                    class="text-sm text-[#007bff] hover:underline flex items-center gap-1">
                    <i class="ph ph-arrow-left"></i> Volver a la lista
                </a>
            @else
                <a href="{{ route('referencias.index') }}"
                    class="text-sm text-[#007bff] hover:underline flex items-center gap-1">
                    <i class="ph ph-arrow-left"></i> Volver a la lista
                </a>
            @endrole
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <p class="font-semibold text-gray-700">Correlativo:</p>
                <p class="text-gray-800">{{ $referencia->correlativo }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Departamento:</p>
                <p class="text-gray-800">{{ $referencia->departamento }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Asunto:</p>
                <p class="text-gray-800">{{ $referencia->asunto ?? '---' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Solicitado por:</p>
                <p class="text-gray-800">{{ $referencia->solicitado_por ?? '---' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Autorizado por:</p>
                <p class="text-gray-800">{{ $referencia->autorizado_por ?? '---' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Generado por:</p>
                <p class="text-gray-800">{{ $referencia->user->name ?? 'N/D' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Fecha de creación:</p>
                <p class="text-gray-800">{{ $referencia->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Última modificación:</p>
                <p class="text-gray-800">{{ $referencia->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-6">
            <p class="font-semibold text-gray-700 mb-2">Documento adjunto:</p>
            @if ($referencia->documento)
                @php
                    $extension = pathinfo($referencia->documento, PATHINFO_EXTENSION);
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $referencia->documento) }}"
                        class="max-w-full h-auto rounded-lg border shadow" alt="Documento">
                @elseif ($extension === 'pdf')
                    <embed src="{{ asset('storage/' . $referencia->documento) }}" type="application/pdf"
                        class="w-full h-[500px] border rounded shadow" />
                @else
                    <p class="text-sm text-gray-500">No se puede mostrar el documento. <a
                            href="{{ asset('storage/' . $referencia->documento) }}" class="text-blue-600 underline"
                            target="_blank">Descargar</a></p>
                @endif
            @else
                <p class="text-sm text-gray-400 italic">No hay documento adjunto.</p>
            @endif
        </div>
    </div>
@endsection
