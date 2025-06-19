@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">Dashboard – {{ Auth::user()->getRoleNames()->first() }}</h2>

        @php
            $rol = Auth::user()->getRoleNames()->first();
            $total = \App\Models\Referencia::where('departamento', $rol)->count();
            $pendientes = \App\Models\Referencia::where('departamento', $rol)->where('estado', 'pendiente')->count();
            $completas = $total - $pendientes;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="bg-white p-6 shadow rounded-xl border">
                <h3 class="text-xl font-semibold text-blue-700">Total</h3>
                <p class="text-3xl font-bold mt-2">{{ $total }}</p>
            </div>
            <div class="bg-yellow-100 p-6 shadow rounded-xl border border-yellow-200">
                <h3 class="text-xl font-semibold text-yellow-700">Pendientes</h3>
                <p class="text-3xl font-bold mt-2">{{ $pendientes }}</p>
            </div>
            <div class="bg-green-100 p-6 shadow rounded-xl border border-green-200">
                <h3 class="text-xl font-semibold text-green-700">Completadas</h3>
                <p class="text-3xl font-bold mt-2">{{ $completas }}</p>
            </div>
        </div>
    </div>
@endsection
