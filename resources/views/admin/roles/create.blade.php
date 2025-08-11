@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Errores --}}
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.516 11.59c.75 1.334-.213 2.998-1.742 2.998H3.483c-1.53 0-2.492-1.664-1.742-2.998L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-7a1 1 0 00-.993.883L9 7v3a1 1 0 001.993.117L11 10V7a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Revisa los campos</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-[#002c5f]">Crear nuevo rol / departamento</h1>
            <p class="text-gray-600">El nombre del rol será también el código de departamento (ej.: GOR, GAF, DE, GSEA…)</p>
        </div>

        {{-- Card form --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow p-6">
            <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nombre del rol / departamento <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Ej.: GOR, GAF, DE, SuperAdmin, Invitado"
                        class="mt-1 block w-full rounded-md border-gray-300 focus:ring-[#007bff] focus:border-[#007bff]">
                    <p class="mt-1 text-xs text-gray-500">Debe ser único.</p>
                </div>

                <div>
                    <label for="clone_from" class="block text-sm font-medium text-gray-700">
                        Clonar permisos desde (opcional)
                    </label>
                    <select id="clone_from" name="clone_from"
                        class="mt-1 block w-full rounded-md border-gray-300 focus:ring-[#007bff] focus:border-[#007bff]">
                        <option value="">— No clonar —</option>
                        @foreach (\Spatie\Permission\Models\Role::orderBy('name')->get() as $r)
                            <option value="{{ $r->name }}" {{ old('clone_from') === $r->name ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Puedes clonar, por ejemplo, desde “SuperAdmin” o cualquier otro
                        rol base.</p>
                </div>

                <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="exclude_user_create" value="1"
                            {{ old('exclude_user_create') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                        <span class="text-sm text-yellow-900">
                            Si clonaste desde un rol con gestión de usuarios, <strong>quitar permisos de crear
                                usuarios</strong>
                            (p. ej. <em>users.create, admin.users.create, users.store</em>).
                        </span>
                    </label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('admin.roles.index') }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#007bff] text-white rounded-lg shadow hover:bg-[#005bb5] transition">
                        <i class="ph ph-floppy-disk text-white text-lg"></i>
                        Guardar rol
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
