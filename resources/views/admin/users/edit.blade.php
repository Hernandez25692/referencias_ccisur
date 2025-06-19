@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Usuario</h2>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Correo</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label>Nueva Contraseña <small>(dejar en blanco si no se cambia)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label>Rol</label>
                <select name="role" class="form-control" required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol }}" {{ $user->hasRole($rol) ? 'selected' : '' }}>{{ $rol }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
