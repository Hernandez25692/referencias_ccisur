@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-2xl font-semibold mb-4">Mis Referencias – {{ Auth::user()->getRoleNames()->first() }}</h2>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('referencias.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">+ Nueva Referencia</a>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2">Correlativo</th>
                    <th class="p-2">Asunto</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Fecha</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($referencias as $ref)
                    <tr class="border-b">
                        <td class="p-2">{{ $ref->correlativo }}</td>
                        <td class="p-2">{{ $ref->asunto ?? '---' }}</td>
                        <td class="p-2">
                            <span
                                class="px-2 py-1 rounded {{ $ref->estado === 'pendiente' ? 'bg-yellow-300' : 'bg-green-300' }}">
                                {{ ucfirst($ref->estado) }}
                            </span>
                        </td>
                        <td class="p-2">{{ $ref->created_at->format('d/m/Y') }}</td>
                        <td class="p-2 flex gap-2">
                            @if ($ref->documento)
                                <a href="{{ asset('storage/' . $ref->documento) }}" class="text-blue-600"
                                    target="_blank">Ver Doc</a>
                            @else
                                <span class="text-gray-400">No adjunto</span>
                            @endif

                            @if ($ref->estado === 'pendiente')
                                <a href="{{ route('referencias.edit', $ref) }}"
                                    class="text-yellow-600 hover:underline">Editar</a>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
