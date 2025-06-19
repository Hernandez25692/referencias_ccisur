@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Dashboard – {{ Auth::user()->getRoleNames()->first() }}</h2>

        @php
            $rol = Auth::user()->getRoleNames()->first();
            $total = \App\Models\Referencia::where('departamento', $rol)->count();
            $pendientes = \App\Models\Referencia::where('departamento', $rol)->where('estado', 'pendiente')->count();
            $completas = $total - $pendientes;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="bg-white p-4 shadow rounded">
                <h3 class="text-xl font-semibold text-blue-700">Total</h3>
                <p class="text-2xl">{{ $total }}</p>
            </div>
            <div class="bg-yellow-100 p-4 shadow rounded">
                <h3 class="text-xl font-semibold text-yellow-700">Pendientes</h3>
                <p class="text-2xl">{{ $pendientes }}</p>
            </div>
            <div class="bg-green-100 p-4 shadow rounded">
                <h3 class="text-xl font-semibold text-green-700">Completadas</h3>
                <p class="text-2xl">{{ $completas }}</p>
            </div>
        </div>
    </div>
@endsection
