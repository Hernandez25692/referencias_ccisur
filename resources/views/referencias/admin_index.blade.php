@extends('layouts.app')

@section('content')
    <style>
        :root {
            --azul-oscuro: #002c5f;
            --celeste: #009fe3;
            --gris-fondo: #f8fafc;
            --gris-borde: #e0e7ef;
            --gris-claro: #e6f2fa;
            --gris-hover: #b3d8f4;
            --blanco: #fff;
            --dorado: #b79a37;
            --gris-placeholder: #7b8794;
        }
        /* ... (todo tu CSS original de filtros y responsive) ... */
        </style>

        <div class="tabla-admin-container">
        <div class="flex items-center justify-center mb-6">
            <h2 class="text-2xl font-bold text-[#002c5f] tracking-tight tabla-admin-titulo text-center">
            <i class="ph ph-files mr-2 text-[#009fe3] text-3xl"></i>
            Referencias por Departamento
            </h2>
        </div>
        <!-- Filtros originales mantenidos -->
        <form method="GET" action="{{ route('referencias.admin') }}" class="tabla-admin-filtros" style="width:100%;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <!-- Input de búsqueda -->
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
            <!-- Estado -->
            <select name="estado"
                class="block w-full md:w-48 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#007bff] focus:border-[#007bff] sm:text-sm rounded-md">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="completo" {{ request('estado') == 'completo' ? 'selected' : '' }}>Completado</option>
            </select>
            <!-- Cantidad por página -->
            <select name="per_page" onchange="this.form.submit()"
                class="block w-full md:w-36 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#007bff] focus:border-[#007bff] sm:text-sm rounded-md">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 por página</option>
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
            <!-- Botones de filtro -->
            <div class="flex gap-2 items-center">
                <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#007bff] hover:bg-[#005bb5] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#007bff] transition">
                Filtrar
                </button>
                <a href="{{ route('referencias.admin') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#007bff] transition">
                Limpiar
                </a>
                @if(request('search') || request('estado') || request('per_page') || request('anio'))
                <span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-semibold rounded bg-yellow-100 text-yellow-800 border border-yellow-200" title="Filtro activo">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707l-4.414 4.414V15a1 1 0 01-1.447.894l-2-1A1 1 0 018 14V10.121L3.293 5.707A1 1 0 013 5V3z" clip-rule="evenodd"/>
                    </svg>
                    Filtro activo
                </span>
                @endif
            </div>
            </div>
        </form>
        <style>
            /* ... (todo tu CSS responsive original) ... */
        </style>

        <!-- Nuevo diseño de tabla -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200 mt-4">
            <div class="overflow-x-auto">
            <table class="min-w-full w-[1400px] max-w-none divide-y divide-gray-200" style="overflow-y: hidden;">
                <style>
                tbody tr {
                    transition: background 0.2s, box-shadow 0.2s;
                }
                tbody tr:hover {
                    background: #e6f0ff !important;
                    box-shadow: 0 2px 8px 0 rgba(0, 44, 95, 0.07);
                    z-index: 1;
                    position: relative;
                }
                tbody tr:nth-child(odd) {
                    background: #f8fafc;
                }
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
                .overflow-x-auto {
                    overflow-y: hidden !important;
                }
                </style>
                <thead class="bg-gradient-to-r from-[#002c5f] to-[#004a9f] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider sticky-col">#</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider sticky-col-2">Correlativo</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Departamento</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Asunto</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Solicitado por</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Autorizado por</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Generado por</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Fecha de Generación</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Última Modificación</th>
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Documento</th>
                    <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">Acciones</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($referencias as $i => $ref)
                    <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 sticky-col">{{ $i + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 sticky-col-2">{{ $ref->correlativo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800 max-w-xs truncate" title="{{ nombreDepartamento($ref->departamento) }}">
                        {{ Str::limit(nombreDepartamento($ref->departamento), 50) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800 max-w-xs truncate" title="{{ $ref->asunto ?? '---' }}">
                        {{ Str::limit($ref->asunto ?? '---', 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $ref->solicitado_por ?? '---' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                        {{ $ref->autorizado_por ?? '---' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                        {{ $ref->user->name ?? 'N/D' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                        {{ $ref->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                        {{ $ref->updated_at->format('d/m/Y H:i') }}
                    </td>
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
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
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
                        <a href="{{ route('referencias.bitacora', $ref->id) }}"
                            class="text-yellow-600 hover:text-yellow-800 transition transform hover:scale-110 relative group"
                            title="Ver historial">
                            <i class="ph ph-clock-counter-clockwise tabla-admin-icon"></i>
                            <span
                            class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            Historial
                            </span>
                        </a>
                        </div>
                    </td>
                    </tr>
                @empty
                    <tr>
                    <td colspan="11" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay referencias registradas</h3>
                        <p class="mt-1 text-sm text-gray-500">Crea una nueva referencia para comenzar</p>
                        </div>
                    </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
            <!-- Paginación -->
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $referencias->links('vendor.pagination.tailwind') }}
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
        </div>
        </div>
    @endsection
