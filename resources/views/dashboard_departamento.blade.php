@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-10 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                @php
                    $mapa = [
                        'GAF' => 'Gerencia Administrativa y Financiera',
                        'GOR' => 'Gerencia de Operaciones Registrales',
                        'GSEA' => 'Gerencia de Servicios Empresariales y Afiliaciones',
                        'DE' => 'Dirección Ejecutiva',
                    ];
                    $rol = Auth::user()->getRoleNames()->first();
                    $deptName = $mapa[$rol] ?? $rol;
                    
                    // Get department stats
                    $total = \App\Models\Referencia::where('departamento', $rol)->count();
                    $pendientes = \App\Models\Referencia::where('departamento', $rol)
                        ->where('estado', 'pendiente')->count();
                    $completas = $total - $pendientes;
                    $porcentaje = $total > 0 ? round(($completas / $total) * 100) : 0;
                @endphp
                
                <h1 class="text-3xl sm:text-4xl font-bold text-[#002c5f] mb-3 animate-fade-in-down">
                    Panel de Control
                </h1>
                <div class="inline-flex items-center bg-white px-4 py-2 rounded-full shadow-sm border border-gray-200 animate-fade-in-down delay-100">
                    <span class="h-3 w-3 rounded-full bg-[#007bff] mr-2"></span>
                    <span class="text-sm font-medium text-gray-700">{{ $deptName }}</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Total Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 animate-fade-in-up">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Referencias</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $total }}</h3>
                            </div>
                            <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendientes Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 animate-fade-in-up delay-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pendientes</p>
                                <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $pendientes }}</h3>
                            </div>
                            <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="h-2 bg-gray-200 rounded-full">
                                <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $total > 0 ? ($pendientes/$total)*100 : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">{{ $total > 0 ? round(($pendientes/$total)*100) : 0 }}% del total</p>
                        </div>
                    </div>
                </div>

                <!-- Completadas Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 animate-fade-in-up delay-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Completadas</p>
                                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $completas }}</h3>
                            </div>
                            <div class="p-3 rounded-lg bg-green-50 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-500">Tasa de completado:</span>
                                <span class="text-sm font-bold text-green-600 ml-2">{{ $porcentaje }}%</span>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <div class="ml-2 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.6s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }
    </style>
@endsection