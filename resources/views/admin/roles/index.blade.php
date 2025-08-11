@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-[#002c5f]">Roles / Departamentos</h1>
                <p class="text-gray-600">Administra los roles del sistema (el nombre del rol es el código de departamento).
                </p>
            </div>
            <a href="{{ route('admin.roles.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#007bff] text-white rounded-lg shadow hover:bg-[#005bb5] transition">
                <i class="ph ph-plus text-white text-lg"></i>
                Nuevo rol
            </a>
        </div>

        {{-- Tabla de roles --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#002c5f] to-[#004a9f] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Guard</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Permisos</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Creado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($roles as $i => $role)
                            <tr class="hover:bg-[#f4f8ff]">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    <span class="font-medium">{{ $role->name }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $role->guard_name }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full bg-[#b79a37]/10 text-[#b79a37] text-xs font-semibold">
                                        {{ $role->permissions()->count() }} permisos
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ optional($role->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    No hay roles creados aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
