@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold text-[#002c5f] mb-2">Referencias –
                    {{ nombreDepartamento(Auth::user()->getRoleNames()->first()) }}
                </h2>
                <p class="text-gray-600">Gestión completa de referencias documentales</p>
            </div>
            <!-- Sección diferenciada para exportar a Excel -->
            <div class="mb-6 border-l-4 border-green-600 bg-green-50 p-4 rounded-md shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4">
                    <form action="{{ route('referencias.export') }}" method="GET" class="flex flex-wrap items-end space-x-2">
                        <div>
                            <label for="desde" class="block text-sm font-medium text-green-900">Desde:</label>
                            <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                onchange="document.getElementById('hasta').min = this.value;">
                        </div>
                        <div>
                            <label for="hasta" class="block text-sm font-medium text-green-900">Hasta:</label>
                            <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                onchange="document.getElementById('desde').max = this.value;">
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const desde = document.getElementById('desde');
                                const hasta = document.getElementById('hasta');
                                if (desde && hasta) {
                                    if (desde.value) hasta.min = desde.value;
                                    if (hasta.value) desde.max = hasta.value;
                                    desde.addEventListener('change', function() {
                                        hasta.min = this.value;
                                    });
                                    hasta.addEventListener('change', function() {
                                        desde.max = this.value;
                                    });
                                }
                            });
                        </script>
                        <div class="mt-4 sm:mt-0">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="ph ph-file-xls mr-1"></i> Exportar por rango
                            </button>
                        </div>
                    </form>
                    <!-- Botón exportar todo -->
                    <div class="mt-2 sm:mt-0">
                        <a href="{{ route('referencias.export') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="ph ph-download-simple mr-1"></i> Exportar Todo
                        </a>
                    </div>
                </div>
            </div>
            <!-- Fin sección exportar excel -->

            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <!-- New Reference Button -->
                <a href="{{ route('referencias.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#007bff] to-[#005bb5] hover:from-[#0069d9] hover:to-[#004a9f] text-white font-medium rounded-md shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Referencia
                </a>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('referencias.index') }}"
                    class="w-full md:w-auto bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-0 md:border-0 md:bg-transparent">
                    <div class="flex flex-col md:flex-row gap-3 w-full">
                        <!-- Search Input -->
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Buscar referencia..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#007bff] focus:border-[#007bff] sm:text-sm transition">
                        </div>

                        <!-- Status Select -->
                        <select name="estado"
                            class="block w-full md:w-48 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#007bff] focus:border-[#007bff] sm:text-sm rounded-md">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente
                            </option>
                            <option value="completo" {{ request('estado') == 'completo' ? 'selected' : '' }}>Completado
                            </option>
                        </select>
                        <!-- Select para cantidad por página -->
                        <select name="per_page" onchange="this.form.submit()"
                            class="block w-full md:w-36 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#007bff] focus:border-[#007bff] sm:text-sm rounded-md">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 por página
                            </option>
                        </select>
                        <!-- Filtro por Año -->
                        <select name="anio" onchange="this.form.submit()"
                            class="block w-full md:w-32 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#007bff] focus:border-[#007bff] sm:text-sm rounded-md">
                            <option value="">Todos los años</option>
                            @foreach ($aniosDisponibles as $anio)
                                <option value="{{ $anio }}" {{ request('anio') == $anio ? 'selected' : '' }}>
                                    {{ $anio }}</option>
                            @endforeach
                        </select>

                        <!-- Filter Buttons -->
                        <div class="flex gap-2 items-center">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#007bff] hover:bg-[#005bb5] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#007bff] transition">
                                Filtrar
                            </button>
                            <a href="{{ route('referencias.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#007bff] transition">
                                Limpiar
                            </a>
                            @if (request('search') || request('estado') || request('per_page') || request('anio'))
                                <span
                                    class="inline-flex items-center px-2 py-1 ml-2 text-xs font-semibold rounded bg-yellow-100 text-yellow-800 border border-yellow-200"
                                    title="Filtro activo">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707l-4.414 4.414V15a1 1 0 01-1.447.894l-2-1A1 1 0 018 14V10.121L3.293 5.707A1 1 0 013 5V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Filtro activo
                                </span>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <!-- Table Container -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                <!-- Responsive Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full w-[1400px] max-w-none divide-y divide-gray-200" style="overflow-y: hidden;">
                        <style>
                            /* Efecto de resalte al pasar el mouse por la fila */
                            tbody tr {
                                transition: background 0.2s, box-shadow 0.2s;
                            }

                            tbody tr:hover {
                                background: #e6f0ff !important;
                                box-shadow: 0 2px 8px 0 rgba(0, 44, 95, 0.07);
                                z-index: 1;
                                position: relative;
                            }

                            /* Alternar color de fondo para filas impares */
                            tbody tr:nth-child(odd) {
                                background: #f8fafc;
                            }

                            /* Fijar la columna del correlativo y # */
                            .sticky-col {
                                position: sticky;
                                left: 0;
                                background: #fff;
                                z-index: 10;
                                box-shadow: 2px 0 6px -2px rgba(0, 0, 0, 0.04);
                            }

                            .sticky-col-2 {
                                position: sticky;
                                left: 56px;
                                /* ancho de la primera columna (#) px-6 = 24px padding + 8px contenido aprox */
                                background: #fff;
                                z-index: 10;
                                box-shadow: 2px 0 6px -2px rgba(0, 0, 0, 0.04);
                            }

                            thead .sticky-col,
                            thead .sticky-col-2 {
                                z-index: 20;
                                background: linear-gradient(to right, #002c5f, #004a9f);
                                color: #fff;
                                box-shadow: 2px 0 6px -2px rgba(0, 0, 0, 0.04);
                            }

                            /* Ocultar barra de desplazamiento vertical en el contenedor padre */
                            .overflow-x-auto {
                                overflow-y: hidden !important;
                            }
                        </style>
                        <thead class="bg-gradient-to-r from-[#002c5f] to-[#004a9f] text-white">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider sticky-col">#</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider sticky-col-2">
                                    Correlativo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Asunto</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Solicitado por</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Autorizado por</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Fecha Generación</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Última Modificación</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Documento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Estado</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($referencias as $index => $ref)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 sticky-col">
                                        {{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 sticky-col-2">
                                        {{ $ref->correlativo }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 max-w-xs truncate"
                                        title="{{ $ref->asunto ?? '---' }}">
                                        {{ Str::limit($ref->asunto ?? '---', 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $ref->solicitado_por ?? '---' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $ref->autorizado_por ?? '---' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $ref->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $ref->updated_at->diffForHumans(null, false, 'es') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        @if ($ref->documento)
                                            <a href="{{ asset('storage/' . $ref->documento) }}" target="_blank"
                                                class="inline-flex items-center text-[#007bff] hover:text-[#005bb5] transition group"
                                                title="Ver documento">
                                                <svg class="h-5 w-5 mr-1 group-hover:animate-bounce" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span class="sr-only">Ver documento</span>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">No adjunto</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($ref->estado === 'pendiente')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Pendiente
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Completado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('referencias.show', $ref->id) }}"
                                                class="text-[#007bff] hover:text-[#005bb5] transition transform hover:scale-110 relative group"
                                                title="Ver detalle">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    Ver
                                                </span>
                                            </a>
                                            <a href="{{ route('referencias.edit', $ref) }}"
                                                class="text-yellow-600 hover:text-yellow-800 transition transform hover:scale-110 relative group"
                                                title="Editar referencia">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    Editar
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay referencias
                                                registradas</h3>
                                            <p class="mt-1 text-sm text-gray-500">Crea una nueva referencia para comenzar
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($referencias->hasPages())
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($referencias->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                                    Anterior
                                </span>
                            @else
                                <a href="{{ $referencias->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Anterior
                                </a>
                            @endif

                            @if ($referencias->hasMorePages())
                                <a href="{{ $referencias->nextPageUrl() }}"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Siguiente
                                </a>
                            @else
                                <span
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                                    Siguiente
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Mostrando
                                    <span class="font-medium">{{ $referencias->firstItem() }}</span>
                                    a
                                    <span class="font-medium">{{ $referencias->lastItem() }}</span>
                                    de
                                    <span class="font-medium">{{ $referencias->total() }}</span>
                                    resultados
                                </p>
                            </div>
                            <div>
                                {{ $referencias->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    html: `<div style="font-size: 14px; font-weight: 500;">{{ session('success') }}</div>`,
                    background: '#f8fafc',
                    color: '#002c5f',
                    iconColor: '#10b981',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'shadow-lg border border-[#b79a37] rounded-lg'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            });
        </script>
    @endif
@endsection
