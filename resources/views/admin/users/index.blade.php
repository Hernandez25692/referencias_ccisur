@extends('layouts.app')

@section('content')
    <!-- Phosphor Icons CDN -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/css/phosphor.css">

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Título -->
            <h2 class="text-3xl font-extrabold text-center text-[#002c5f] mb-8">Usuarios del Sistema</h2>




            <!-- Botón agregar -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-full shadow-lg bg-[#007bff] hover:bg-[#005bb5] text-white font-semibold text-base transition duration-200">
                    <i class="ph ph-plus-circle text-xl"></i>
                    Nuevo Usuario
                </a>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto rounded-xl shadow-lg bg-white">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-[#002c5f] text-white">
                        <tr>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">#</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wide">Nombre</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wide">Correo</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wide">Rol</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wide">Departamento</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wide">Fecha de Registro</th>
                            <th class="px-6 py-4 text-center font-bold uppercase tracking-wide">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($users as $index => $user)
                            <tr class="hover:bg-[#f0f4fa] transition-colors">
                                <td class="px-4 py-4 text-gray-500 text-center font-semibold">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $role = $user->getRoleNames()->first();
                                        $roleColors = [
                                            'Admin' => 'bg-[#007bff] text-white',
                                            'Usuario' => 'bg-gray-200 text-[#002c5f]',
                                            'SuperAdmin' => 'bg-red-600 text-white',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $roleColors[$role] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    @php
                                        $role = $user->getRoleNames()->first();
                                        $mapaDepartamentos = [
                                            'DE' => 'Dirección Ejecutiva',
                                            'GOR' => 'Gerencia de Operaciones Registrales',
                                            'GAF' => 'Gerencia Administrativa y Financiera',
                                            'GSEA' => 'Gerencia de Servicios Empresariales y Afiliaciones',
                                        ];
                                        $nombreDepto = $mapaDepartamentos[$role] ?? '---';
                                    @endphp
                                    {{ $nombreDepto }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center justify-center p-2 rounded-full hover:bg-[#e6f0ff] text-[#007bff] focus:outline-none focus:ring-2 focus:ring-[#007bff]"
                                        title="Editar usuario">
                                        <i class="ph ph-pencil-simple text-lg"></i>
                                    </a>
                                    {{-- No eliminar usuarios por seguridad de relaciones --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400 italic">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Mensaje de éxito -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    html: `<div style="font-size: 14px; font-weight: 500;">{{ session('success') }}</div>`,
                    background: '#f8fafc',
                    color: '#002c5f',
                    iconColor: '#10b981',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'shadow-lg border border-[#b79a37] rounded-lg'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            });
        </script>
    @endif
@endsection
