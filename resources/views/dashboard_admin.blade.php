@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-[#002c5f]">Dashboard General – SuperAdmin</h2>
        <p class="text-sm text-gray-500">Resumen de referencias por departamento</p>
    </div>

    @php
        $departamentos = ['GAF', 'GOR', 'GSEA', 'DE'];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        @foreach ($departamentos as $dep)
            @php
                $total = \App\Models\Referencia::where('departamento', $dep)->count();
                $pendientes = \App\Models\Referencia::where('departamento', $dep)->where('estado', 'pendiente')->count();
                $completas = $total - $pendientes;
            @endphp

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="text-xl font-semibold text-[#007bff] mb-2">Departamento {{ $dep }}</h3>
                <ul class="text-sm space-y-1">
                    <li>Total: <strong class="text-gray-800">{{ $total }}</strong></li>
                    <li>Pendientes: <strong class="text-yellow-600">{{ $pendientes }}</strong></li>
                    <li>Completadas: <strong class="text-green-600">{{ $completas }}</strong></li>
                </ul>
            </div>
        @endforeach
    </div>
@endsection
