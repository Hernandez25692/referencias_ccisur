@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-center text-[#002c5f] mb-6">Referencias por Departamento</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-lg rounded-xl overflow-hidden border border-[#002c5f]">
                <thead class="bg-gradient-to-r from-[#002c5f] to-[#009fe3] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">#</th>
                        <th class="px-4 py-3 text-left font-semibold">Correlativo</th>
                        <th class="px-4 py-3 text-left font-semibold">Departamento</th>
                        <th class="px-4 py-3 text-left font-semibold">Asunto</th>
                        <th class="px-4 py-3 text-left font-semibold">Solicitado por</th>
                        <th class="px-4 py-3 text-left font-semibold">Autorizado por</th>
                        <th class="px-4 py-3 text-left font-semibold">Generado por</th>
                        <th class="px-4 py-3 text-left font-semibold">Fecha de Generación</th>
                        <th class="px-4 py-3 text-left font-semibold">Última Modificación</th>
                        <th class="px-4 py-3 text-left font-semibold">Documento</th>
                        <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#009fe3] text-sm">
                    @foreach ($referencias as $i => $ref)
                        <tr class="{{ $i % 2 == 0 ? 'bg-[#e6f2fa]' : 'bg-white' }} transition hover:bg-[#b3d8f4] border-l-4 {{ $i % 2 == 0 ? 'border-[#009fe3]' : 'border-[#002c5f]' }}">
                            <td class="px-4 py-3 font-bold text-[#002c5f]">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-[#009fe3]">{{ $ref->correlativo }}</td>
                            <td class="px-4 py-3">{{ nombreDepartamento($ref->departamento) }}</td>
                            <td class="px-4 py-3">{{ $ref->asunto ?? '---' }}</td>
                            <td class="px-4 py-3">{{ $ref->solicitado_por ?? '---' }}</td>
                            <td class="px-4 py-3">{{ $ref->autorizado_por ?? '---' }}</td>
                            <td class="px-4 py-3 text-[#002c5f] font-medium">
                                {{ $ref->user->name ?? 'N/D' }}
                            </td>
                            <td class="px-4 py-3">{{ $ref->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $ref->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                @if ($ref->documento)
                                    <a href="{{ asset('storage/' . $ref->documento) }}"
                                        class="inline-block px-2 py-1 bg-[#009fe3] text-white rounded hover:bg-[#002c5f] transition"
                                        target="_blank">Ver</a>
                                @else
                                    <span class="text-gray-400 italic">No adjunto</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('referencias.show', $ref->id) }}"
                                        class="text-[#009fe3] hover:text-[#002c5f] transition" title="Ver detalle">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
