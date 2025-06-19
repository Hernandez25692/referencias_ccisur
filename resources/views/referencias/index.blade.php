@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-[#002c5f] mb-8">Referencias –
            {{ Auth::user()->getRoleNames()->first() }}</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-6">
            <a href="{{ route('referencias.create') }}"
                class="bg-[#007bff] hover:bg-[#005bb5] text-white font-semibold px-5 py-2 rounded shadow transition">
                + Nueva Referencia
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow border border-gray-200 rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#002c5f] text-white">
                    <tr>
                        <th class="px-4 py-3">Correlativo</th>
                        <th class="px-4 py-3">Asunto</th>
                        <th class="px-4 py-3">Solicitado por</th>
                        <th class="px-4 py-3">Autorizado por</th>
                        <th class="px-4 py-3">Fecha de Generación</th>
                        <th class="px-4 py-3">Última Modificación</th>
                        <th class="px-4 py-3">Documento</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($referencias as $ref)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-semibold">{{ $ref->correlativo }}</td>
                            <td class="px-4 py-3">{{ $ref->asunto ?? '---' }}</td>
                            <td class="px-4 py-3">{{ $ref->solicitado_por ?? '---' }}</td>
                            <td class="px-4 py-3">{{ $ref->autorizado_por ?? '---' }}</td>
                            <td class="px-4 py-3">{{ $ref->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $ref->updated_at->diffForHumans(null, false, 'es') }}</td>
                            <td class="px-4 py-3">
                                @if ($ref->documento)
                                    <a href="{{ asset('storage/' . $ref->documento) }}" target="_blank"
                                        class="text-blue-600 hover:underline flex items-center gap-1">
                                        <i class="ph ph-file-arrow-down"></i> Ver
                                    </a>
                                @else
                                    <span class="text-gray-400">No adjunto</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-bold
                                    {{ $ref->estado === 'pendiente' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                    {{ ucfirst($ref->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    @if ($ref->estado === 'pendiente')
                                        <a href="{{ route('referencias.edit', $ref) }}"
                                            class="text-yellow-600 hover:underline">
                                            <i class="ph ph-pencil-simple"></i> Editar
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">No hay referencias registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
