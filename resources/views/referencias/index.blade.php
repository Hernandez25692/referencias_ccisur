@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-[#002c5f] mb-8">Referencias –
            {{ nombreDepartamento(Auth::user()->getRoleNames()->first()) }}
        </h2>



        <div class="flex justify-end mb-6">
            <a href="{{ route('referencias.create') }}"
                class="bg-[#007bff] hover:bg-[#005bb5] text-white font-semibold px-5 py-2 rounded shadow transition">
                + Nueva Referencia
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow border border-gray-200 rounded-lg">
            <!-- Filtros con formulario -->
            <form method="GET" action="{{ route('referencias.index') }}"
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-4 bg-[#f8fafc] border-b border-gray-200 rounded-t-lg">
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative w-full md:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#007bff]">
                            <i class="ph ph-magnifying-glass text-lg"></i>
                        </span>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Buscar referencia..."
                            class="block w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-[#007bff] focus:ring-[#007bff]/30 text-gray-800 placeholder-gray-400 bg-white transition" />
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <select name="estado"
                        class="rounded-lg border border-gray-300 text-gray-800 focus:border-[#007bff] focus:ring-[#007bff]/30 px-3 py-2 bg-white">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente
                        </option>
                        <option value="completo" {{ request('estado') == 'completo' ? 'selected' : '' }}>Completado
                        </option>
                    </select>
                    <button type="submit"
                        class="bg-[#007bff] hover:bg-[#005bb5] text-white px-4 py-2 rounded shadow transition">
                        Filtrar
                    </button>
                </div>
            </form>


            <div class="overflow-x-auto">
                <table id="referencias-table"
                    class="min-w-full text-sm text-left divide-y divide-gray-200 border border-gray-200 rounded-b-lg bg-white">
                    <thead class="bg-[#002c5f] text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">#</th>
                            <th class="px-6 py-4 font-semibold">Correlativo</th>
                            <th class="px-6 py-4 font-semibold">Asunto</th>
                            <th class="px-6 py-4 font-semibold">Solicitado por</th>
                            <th class="px-6 py-4 font-semibold">Autorizado por</th>
                            <th class="px-6 py-4 font-semibold">Fecha de Generación</th>
                            <th class="px-6 py-4 font-semibold">Última Modificación</th>
                            <th class="px-6 py-4 font-semibold">Documento</th>
                            <th class="px-6 py-4 font-semibold">Estado</th>
                            <th class="px-6 py-4 font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-800">
                        @forelse ($referencias as $index => $ref)
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-4 font-bold whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-bold whitespace-nowrap">{{ $ref->correlativo }}</td>
                                <td class="px-6 py-4">{{ $ref->asunto ?? '---' }}</td>
                                <td class="px-6 py-4 font-bold">{{ $ref->solicitado_por ?? '---' }}</td>
                                <td class="px-6 py-4">{{ $ref->autorizado_por ?? '---' }}</td>
                                <td class="px-6 py-4">{{ $ref->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">{{ $ref->updated_at->diffForHumans(null, false, 'es') }}</td>
                                <td class="px-6 py-4">
                                    @if ($ref->documento)
                                        <a href="{{ asset('storage/' . $ref->documento) }}" target="_blank"
                                            class="flex items-center gap-1 text-[#007bff] hover:underline group"
                                            title="Ver documento">
                                            <i class="ph ph-file-arrow-down text-lg group-hover:text-[#005bb5]"></i>
                                            <span class="sr-only">Ver documento</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400">No adjunto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($ref->estado === 'pendiente')
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-yellow-200 text-yellow-900 border border-yellow-300"
                                            title="Pendiente">
                                            <i text-yellow-700 mr-1"></i> Pendiente
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-200 text-green-900 border border-green-300"
                                            title="completado">
                                            <i text-green-700 mr-1"></i> completado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('referencias.show', $ref->id) }}"
                                            class="text-[#007bff] hover:text-[#005bb5] transition group relative"
                                            title="Ver detalle">
                                            <i class="ph ph-eye text-lg"></i>
                                            <span class="sr-only">Ver detalle</span>
                                        </a>
                                        <a href="{{ route('referencias.edit', $ref) }}"
                                            class="text-yellow-600 hover:text-yellow-800 transition group relative"
                                            title="Editar referencia">
                                            <i class="ph ph-pencil-simple text-lg"></i>
                                            <span class="sr-only">Editar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-gray-500">No hay referencias
                                    registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-white border-t border-gray-200">
                    {{ $referencias->links('vendor.pagination.tailwind') }}
                </div>

            </div>

            {{-- DataTables JS --}}

        </div>
    </div>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Acción completada!',
                    text: "{{ session('success') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
@endsection
