@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <h2 class="text-2xl font-bold text-[#002c5f] mb-4">Historial de cambios – {{ $referencia->correlativo }}</h2>

        

        @if ($referencia->bitacoras->count())
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <table class="w-full text-sm divide-y divide-gray-200">
                    <thead class="bg-[#002c5f] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Acción</th>
                            <th class="px-4 py-3 text-left">Detalle</th>
                            <th class="px-4 py-3 text-left">Realizado por</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($referencia->bitacoras as $log)
                            <tr class="hover:bg-[#f0f4ff]">
                                <td class="px-4 py-2 text-gray-700">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 font-semibold text-[#b79a37] capitalize">{{ $log->accion }}</td>
                                <td class="px-4 py-2">{{ $log->cambios }}</td>
                                <td class="px-4 py-2 text-[#002c5f]">{{ $log->user->name ?? 'Usuario desconocido' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No hay registros en la bitácora para esta referencia.</p>
        @endif
    </div>
@endsection
