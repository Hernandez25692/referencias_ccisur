@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <!-- Encabezado mejorado -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                <span class="inline-block pb-1 border-b-2 border-[#002c5f]">Historial de cambios</span>
            </h1>
            <p class="text-gray-600 mt-1">
                Referencia: <span class="font-semibold text-[#002c5f]">{{ $referencia->correlativo }}</span>
            </p>
        </div>
        
        <a href="{{ url('/referencias/admin') }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#002c5f] hover:bg-[#0056b3] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#002c5f] transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la lista
        </a>
    </div>

    <!-- Contenedor principal -->
    @if ($referencia->bitacoras->count())
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#002c5f] to-[#0056b3]">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Fecha y Hora
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Acción
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Detalle de Cambios
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Usuario
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($referencia->bitacoras as $log)
                    <tr class="transition-colors duration-150 hover:bg-blue-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="font-medium">{{ $log->created_at->format('d/m/Y') }}</div>
                            <div class="text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($log->accion === 'creación') bg-green-100 text-green-800
                                @elseif($log->accion === 'actualización') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($log->accion) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {!! nl2br(e($log->cambios)) !!}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $log->user->name ?? 'Usuario desconocido' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-6 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">No hay registros en el historial</h3>
        <p class="mt-1 text-gray-500">No se encontraron cambios registrados para esta referencia.</p>
    </div>
    @endif
</div>

<!-- Estilos compatibles -->
<style>
    /* Transiciones suaves */
    .transition-colors {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
    
    /* Sombras compatibles */
    .shadow {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    
    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    /* Bordes redondeados */
    .rounded-xl {
        border-radius: 0.75rem;
    }
    
    /* Efecto hover para filas */
    .hover\:bg-blue-50:hover {
        background-color: #f8fafc;
    }
    
    /* Gradiente compatible */
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
    
    /* Estados de focus para accesibilidad */
    .focus\:outline-none:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
    }
    
    .focus\:ring-2:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
    }
</style>
@endsection
