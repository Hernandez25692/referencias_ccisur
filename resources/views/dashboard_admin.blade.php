@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-10 text-center sm:text-left">
                <h1 class="text-3xl font-extrabold text-[#002c5f] sm:text-4xl">
                    Dashboard General – SuperAdmin
                </h1>
                <p class="mt-2 text-lg text-gray-600 max-w-3xl">
                    Resumen estadístico de referencias por departamento
                </p>
                <div class="mt-4 border-t border-gray-200 pt-4">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4">
                        <div class="flex items-center">
                            <span class="h-3 w-3 rounded-full bg-[#007bff] mr-2"></span>
                            <span class="text-sm text-gray-600">Total de referencias</span>
                        </div>
                        <div class="flex items-center">
                            <span class="h-3 w-3 rounded-full bg-yellow-500 mr-2"></span>
                            <span class="text-sm text-gray-600">Pendientes</span>
                        </div>
                        <div class="flex items-center">
                            <span class="h-3 w-3 rounded-full bg-green-500 mr-2"></span>
                            <span class="text-sm text-gray-600">Completadas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats Grid -->
            @php
                $departamentos = ['GAF', 'GOR', 'GSEA', 'DE'];
                $colors = [
                    'GAF' => 'from-blue-600 to-blue-400',
                    'GOR' => 'from-purple-600 to-purple-400',
                    'GSEA' => 'from-emerald-600 to-emerald-400',
                    'DE' => 'from-amber-600 to-amber-400',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($departamentos as $dep)
                    @php
                        $total = \App\Models\Referencia::where('departamento', $dep)->count();
                        $pendientes = \App\Models\Referencia::where('departamento', $dep)
                            ->where('estado', 'pendiente')
                            ->count();
                        $completas = $total - $pendientes;
                        $porcentaje = $total > 0 ? round(($completas / $total) * 100) : 0;
                    @endphp

                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r {{ $colors[$dep] }} px-6 py-4">
                            <h3 class="text-lg font-semibold text-white">Departamento {{ $dep }}</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700">Progreso</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $porcentaje }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r {{ $colors[$dep] }} h-2.5 rounded-full"
                                        style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total:</span>
                                    <span class="font-bold text-gray-900">{{ $total }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Pendientes:</span>
                                    <span class="font-bold text-yellow-600">{{ $pendientes }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Completadas:</span>
                                    <span class="font-bold text-green-600">{{ $completas }}</span>
                                </div>
                            </div>

                            <!-- View Details Button -->
                            <a href="{{ route('referencias.admin') }}"
                                class="mt-6 inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#002c5f] hover:bg-[#001a3f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#002c5f] transition">
                                Ver detalles
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary Section -->
            <div class="mt-12 bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Resumen General</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Total References -->
                        <div class="text-center">
                            <div class="text-4xl font-bold text-[#002c5f]">
                                {{ \App\Models\Referencia::count() }}
                            </div>
                            <div class="mt-2 text-sm font-medium text-gray-500">TOTAL REFERENCIAS</div>
                            <div class="mt-4 h-1 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-[#002c5f]" style="width: 100%"></div>
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-600">
                                {{ \App\Models\Referencia::where('estado', 'pendiente')->count() }}
                            </div>
                            <div class="mt-2 text-sm font-medium text-gray-500">PENDIENTES</div>
                            <div class="mt-4 h-1 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-500"
                                    style="width: {{ \App\Models\Referencia::count() > 0 ? round((\App\Models\Referencia::where('estado', 'pendiente')->count() / \App\Models\Referencia::count()) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Completed -->
                        <div class="text-center">
                            <div class="text-4xl font-bold text-green-600">
                                {{ \App\Models\Referencia::where('estado', 'completo')->count() }}
                            </div>
                            <div class="mt-2 text-sm font-medium text-gray-500">COMPLETADAS</div>
                            <div class="mt-4 h-1 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500"
                                    style="width: {{ \App\Models\Referencia::count() > 0 ? round((\App\Models\Referencia::where('estado', 'completo')->count() / \App\Models\Referencia::count()) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
