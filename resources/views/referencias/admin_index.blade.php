@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-center text-[#002c5f] mb-6">Referencias por Departamento</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                <thead class="bg-[#002c5f] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Correlativo</th>
                        <th class="px-4 py-2 text-left">Departamento</th>
                        <th class="px-4 py-2 text-left">Asunto</th>
                        <th class="px-4 py-2 text-left">Solicitado por</th>
                        <th class="px-4 py-2 text-left">Autorizado por</th>
                        <th class="px-4 py-2 text-left">Generado por</th>
                        <th class="px-4 py-2 text-left">Fecha de Generación</th>
                        <th class="px-4 py-2 text-left">Última Modificación</th>
                        <th class="px-4 py-2 text-left">Documento</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach ($referencias as $ref)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $ref->correlativo }}</td>
                            <td class="px-4 py-2">{{ $ref->departamento }}</td>
                            <td class="px-4 py-2">{{ $ref->asunto ?? '---' }}</td>
                            <td class="px-4 py-2">{{ $ref->solicitado_por ?? '---' }}</td>
                            <td class="px-4 py-2">{{ $ref->autorizado_por ?? '---' }}</td>
                            <td class="px-4 py-2 text-blue-800 font-medium">
                                {{ $ref->user->name ?? 'N/D' }}
                            </td>
                            <td class="px-4 py-2">{{ $ref->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $ref->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">
                                @if ($ref->documento)
                                    <a href="{{ asset('storage/' . $ref->documento) }}"
                                        class="text-blue-600 hover:underline" target="_blank">Ver</a>
                                @else
                                    <span class="text-gray-400 italic">No adjunto</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
