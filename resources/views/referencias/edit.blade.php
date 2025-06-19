@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-2xl font-semibold mb-4">Editar Referencia – {{ $referencia->correlativo }}</h2>

        <form action="{{ route('referencias.update', $referencia) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Asunto</label>
                <input type="text" name="asunto" class="w-full border p-2 rounded"
                    value="{{ old('asunto', $referencia->asunto) }}">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Solicitado por</label>
                <input type="text" name="solicitado_por" class="w-full border p-2 rounded"
                    value="{{ old('solicitado_por', $referencia->solicitado_por) }}">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Autorizado por</label>
                <input type="text" name="autorizado_por" class="w-full border p-2 rounded"
                    value="{{ old('autorizado_por', $referencia->autorizado_por) }}">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Documento</label><br>
                @if ($referencia->documento)
                    <a href="{{ asset('storage/' . $referencia->documento) }}" target="_blank" class="text-blue-600">Ver
                        actual</a>
                @else
                    <span class="text-gray-400">No adjunto</span>
                @endif
                <input type="file" name="documento" class="w-full border mt-2 p-2 rounded">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Actualizar</button>
                <a href="{{ route('referencias.index') }}" class="bg-gray-300 px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
