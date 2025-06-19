@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Dashboard General – SuperAdmin</h2>

        @php
            $departamentos = ['GAF', 'GOR', 'GSEA', 'DE'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($departamentos as $dep)
                @php
                    $total = \App\Models\Referencia::where('departamento', $dep)->count();
                    $pendientes = \App\Models\Referencia::where('departamento', $dep)
                        ->where('estado', 'pendiente')
                        ->count();
                    $completas = $total - $pendientes;
                @endphp

                <div class="bg-white shadow p-4 rounded">
                    <h3 class="text-lg font-semibold text-blue-800">Departamento {{ $dep }}</h3>
                    <p>Total: <strong>{{ $total }}</strong></p>
                    <p>Pendientes: <strong class="text-yellow-600">{{ $pendientes }}</strong></p>
                    <p>Completadas: <strong class="text-green-600">{{ $completas }}</strong></p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
