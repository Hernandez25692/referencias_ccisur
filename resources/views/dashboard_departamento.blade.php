@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-[#002c5f] mb-10 animate-fade-in-up">Dashboard –
            @php
                $mapa = [
                    'GAF' => 'Gerencia Administrativa y Financiera',
                    'GOR' => 'Gerencia de Operaciones Registrales',
                    'GSEA' => 'Gerencia de Servicios Empresariales y Afiliaciones',
                    'DE' => 'Dirección Ejecutiva',
                ];
                $rol = Auth::user()->getRoleNames()->first();
            @endphp
            {{ $mapa[$rol] ?? $rol }}
        </h2>

        @php
            $total = \App\Models\Referencia::where('departamento', $rol)->count();
            $pendientes = \App\Models\Referencia::where('departamento', $rol)->where('estado', 'pendiente')->count();
            $completas = $total - $pendientes;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
            <!-- Total -->
            <div
                class="bg-white border border-[#e5e7eb] rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 animate-fade-in-up">
                <div class="text-[#002c5f] text-4xl font-black mb-2">
                    <i class="ph ph-clipboard-text"></i>
                </div>
                <h3 class="text-xl font-bold text-[#002c5f]">Total</h3>
                <p class="text-3xl font-extrabold mt-2 text-gray-800">{{ $total }}</p>
            </div>

            <!-- Pendientes -->
            <div
                class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 animate-fade-in-up delay-100">
                <div class="text-yellow-600 text-4xl font-black mb-2">
                    <i class="ph ph-clock-afternoon"></i>
                </div>
                <h3 class="text-xl font-bold text-yellow-700">Pendientes</h3>
                <p class="text-3xl font-extrabold mt-2">{{ $pendientes }}</p>
            </div>

            <!-- Completadas -->
            <div
                class="bg-green-50 border border-green-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 animate-fade-in-up delay-200">
                <div class="text-green-600 text-4xl font-black mb-2">
                    <i class="ph ph-check-circle"></i>
                </div>
                <h3 class="text-xl font-bold text-green-700">Completadas</h3>
                <p class="text-3xl font-extrabold mt-2">{{ $completas }}</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out both;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }
    </style>
@endsection
