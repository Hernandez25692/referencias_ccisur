@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-center text-[#002c5f] mb-6">Referencias por Departamento</h2>
        <form method="GET" action="{{ route('referencias.admin') }}"
            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-4 py-3 bg-[#f8fafc] border border-[#002c5f] rounded-md mb-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por texto..."
                    class="w-full md:w-64 px-3 py-2 rounded border border-gray-300 focus:border-[#009fe3] focus:ring-[#009fe3]/30 placeholder-gray-500" />

                <select name="estado"
                    class="px-3 py-2 rounded border border-gray-300 focus:border-[#009fe3] focus:ring-[#009fe3]/30 bg-white text-gray-700">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="completo" {{ request('estado') == 'completo' ? 'selected' : '' }}>Completado</option>
                </select>

                <select name="departamento"
                    class="px-3 py-2 rounded border border-gray-300 focus:border-[#009fe3] focus:ring-[#009fe3]/30 bg-white text-gray-700">
                    <option value="">Todos los departamentos</option>
                    @foreach ($departamentos as $depto)
                        <option value="{{ $depto }}" {{ request('departamento') == $depto ? 'selected' : '' }}>
                            {{ nombreDepartamento($depto) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 mt-2 md:mt-0">
                <button type="submit"
                    class="bg-[#009fe3] hover:bg-[#002c5f] text-white px-4 py-2 rounded shadow font-semibold transition">
                    Filtrar
                </button>
                <a href="{{ route('referencias.admin') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded shadow transition">
                    Limpiar
                </a>
            </div>
        </form>

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
                        <tr
                            class="{{ $i % 2 == 0 ? 'bg-[#e6f2fa]' : 'bg-white' }} transition hover:bg-[#b3d8f4] border-l-4 {{ $i % 2 == 0 ? 'border-[#009fe3]' : 'border-[#002c5f]' }}">
                            <td class="px-4 py-3 font-bold text-[#002c5f]">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-[#009fe3] whitespace-nowrap">
                                {{ Str::limit($ref->correlativo, 50, '...') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ Str::limit(nombreDepartamento($ref->departamento), 50, '...') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ Str::limit($ref->asunto ?? '---', 30, '...') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ Str::limit($ref->solicitado_por ?? '---', 50, '...') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ Str::limit($ref->autorizado_por ?? '---', 50, '...') }}
                            </td>
                            <td class="px-4 py-3 text-[#002c5f] font-medium">
                                {{ Str::limit($ref->user->name ?? 'N/D', 50, '...') }}
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('referencias.bitacora', $ref->id) }}"
                                        class="text-[#b79a37] hover:text-[#002c5f]" title="Ver historial">
                                        <i class="ph ph-clock-counter-clockwise text-lg"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 px-2">
                {{ $referencias->links('vendor.pagination.tailwind') }}
            </div>

        </div>
    </div>
@endsection
