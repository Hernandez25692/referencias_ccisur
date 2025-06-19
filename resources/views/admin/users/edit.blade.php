@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/css/phosphor.css">

    <div class="min-h-screen flex items-center justify-center bg-[#0c1c3c] py-8 px-4">
        <div class="backdrop-blur-lg bg-white/10 max-w-3xl w-full mx-auto mt-8 rounded-xl shadow-xl p-6 md:p-10">
            <div class="flex items-center gap-3 justify-center mb-8">
                <i class="ph ph-user-gear text-[#b79a37] text-4xl"></i>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Editar Usuario</h2>
            </div>
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-semibold text-white mb-1">Nombre completo</label>
                    <div class="relative">
                        <i class="ph ph-user absolute left-3 top-1/2 -translate-y-1/2 text-[#b79a37] text-lg"></i>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="pl-10 pr-4 py-3 w-full rounded-lg bg-white/20 text-white placeholder-gray-300 border border-transparent focus:border-[#b79a37] focus:ring-2 focus:ring-[#b79a37] outline-none transition sm:text-base"
                            placeholder="Nombre completo" required autofocus
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo letras y espacios"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, ''); 
                                     this.value = this.value.replace(/\b\w/g, c => c.toUpperCase());">
                    </div>
                    @error('name')
                        <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-1">Correo electrónico</label>
                    <div class="relative">
                        <i class="ph ph-envelope-simple absolute left-3 top-1/2 -translate-y-1/2 text-[#b79a37] text-lg"></i>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="pl-10 pr-4 py-3 w-full rounded-lg bg-white/20 text-white placeholder-gray-300 border border-transparent focus:border-[#b79a37] focus:ring-2 focus:ring-[#b79a37] outline-none transition sm:text-base"
                            placeholder="Correo electrónico" required>
                    </div>
                    @error('email')
                        <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-white mb-1">Nueva Contraseña <small class="text-gray-300">(dejar en blanco si no se cambia)</small></label>
                        <div class="relative">
                            <i class="ph ph-lock-key absolute left-3 top-1/2 -translate-y-1/2 text-[#b79a37] text-lg"></i>
                            <input type="password" name="password" id="password"
                                class="pl-10 pr-4 py-3 w-full rounded-lg bg-white/20 text-white placeholder-gray-300 border border-transparent focus:border-[#b79a37] focus:ring-2 focus:ring-[#b79a37] outline-none transition sm:text-base"
                                placeholder="Nueva contraseña">
                            <button type="button" onclick="togglePassword('password', this)" tabindex="-1"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#b79a37] bg-transparent border-none p-0 focus:outline-none">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-white mb-1">Confirmar Nueva Contraseña</label>
                        <div class="relative">
                            <i class="ph ph-lock-key-open absolute left-3 top-1/2 -translate-y-1/2 text-[#b79a37] text-lg"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="pl-10 pr-4 py-3 w-full rounded-lg bg-white/20 text-white placeholder-gray-300 border border-transparent focus:border-[#b79a37] focus:ring-2 focus:ring-[#b79a37] outline-none transition sm:text-base"
                                placeholder="Confirmar nueva contraseña">
                            <button type="button" onclick="togglePassword('password_confirmation', this)" tabindex="-1"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#b79a37] bg-transparent border-none p-0 focus:outline-none">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <script>
                    function togglePassword(fieldId, btn) {
                        const input = document.getElementById(fieldId);
                        const icon = btn.querySelector('i');
                        if (input.type === "password") {
                            input.type = "text";
                            icon.classList.remove('ph-eye');
                            icon.classList.add('ph-eye-slash');
                        } else {
                            input.type = "password";
                            icon.classList.remove('ph-eye-slash');
                            icon.classList.add('ph-eye');
                        }
                    }
                </script>

                <div>
                    <label for="role" class="block text-sm font-semibold text-white mb-1">Rol del usuario</label>
                    <div class="relative">
                        <i class="ph ph-identification-card absolute left-3 top-1/2 -translate-y-1/2 text-[#b79a37] text-lg"></i>
                        <select name="role" id="role"
                            class="pl-10 pr-4 py-3 w-full rounded-lg bg-white/20 text-black border border-transparent focus:border-[#b79a37] focus:ring-2 focus:ring-[#b79a37] outline-none transition sm:text-base appearance-none"
                            required>
                            <option value="" disabled>Selecciona un rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol }}" {{ $user->hasRole($rol) ? 'selected' : '' }}>{{ $rol }}</option>
                            @endforeach
                        </select>
                        <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-[#b79a37] text-base pointer-events-none"></i>
                    </div>
                    @error('role')
                        <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center px-6 py-2 rounded-lg bg-white/20 hover:bg-white/30 text-white text-sm font-semibold shadow transition">
                        <i class="ph ph-arrow-u-left text-base mr-2"></i> Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-7 py-2 rounded-lg bg-[#b79a37] hover:bg-[#a4882e] text-[#0c1c3c] text-sm font-bold shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#b79a37]">
                        <i class="ph ph-floppy-disk text-base mr-2"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
