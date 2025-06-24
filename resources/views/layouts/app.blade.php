<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REFSIS - CCISur</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#f8fafc] text-gray-900 font-sans antialiased">
    <header class="bg-white shadow-md fixed top-0 inset-x-0 z-50 border-b border-[#e5e7eb]">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo y Título -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('storage/logos/logo3.png') }}" alt="Logo CCISur"
                            class="h-10 w-10 object-contain bg-transparent" />
                    </a>
                    <span class="text-2xl font-bold tracking-tight select-none font-sans">
                        <span class="text-[#002c5f]">REF</span><span class="text-[#b79a37]">SIS</span>
                    </span>
                </div>
                <!-- Navegación Escritorio -->
                <ul class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    @role('SuperAdmin')
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center gap-2 px-2 py-1 rounded transition hover:text-[#007bff] hover:bg-[#f3f6fa] focus:outline-none focus:ring-2 focus:ring-[#b79a37]"
                                aria-label="Usuarios">
                                <i class="ph ph-users-four text-[#b79a37] text-lg"></i>
                                <span class="text-[#0c1c3c]">Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('referencias.admin') }}"
                                class="flex items-center gap-2 px-2 py-1 rounded transition hover:text-[#007bff] hover:bg-[#f3f6fa] focus:outline-none focus:ring-2 focus:ring-[#b79a37]"
                                aria-label="Referencias por Departamento">
                                <i class="ph ph-list-magnifying-glass text-[#b79a37] text-lg"></i>
                                <span class="text-[#0c1c3c]">Referencias Por Departamento</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2 px-2 py-1 rounded transition hover:text-[#007bff] hover:bg-[#f3f6fa] focus:outline-none focus:ring-2 focus:ring-[#b79a37]"
                                aria-label="Dashboard">
                                <i class="ph ph-gauge text-[#b79a37] text-lg"></i>
                                <span class="text-[#0c1c3c]">Dashboard</span>
                            </a>
                        </li>
                    @endrole

                    @hasanyrole('GAF|GOR|GSEA|DE')
                        <li>
                            <a href="{{ route('referencias.index') }}"
                                class="flex items-center gap-2 px-2 py-1 rounded transition hover:text-[#007bff] hover:bg-[#f3f6fa] focus:outline-none focus:ring-2 focus:ring-[#b79a37]"
                                aria-label="Mis Referencias">
                                <i class="ph ph-folder-user text-[#b79a37] text-lg"></i>
                                <span class="text-[#0c1c3c]">Mis Referencias</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2 px-2 py-1 rounded transition hover:text-[#007bff] hover:bg-[#f3f6fa] focus:outline-none focus:ring-2 focus:ring-[#b79a37]"
                                aria-label="Dashboard">
                                <i class="ph ph-gauge text-[#b79a37] text-lg"></i>
                                <span class="text-[#0c1c3c]">Dashboard</span>
                            </a>
                        </li>
                    @endhasanyrole

                </ul>
                <!-- Usuario y Logout Mejorado -->
                <div class="flex items-center space-x-4 text-sm">
                    <div
                        class="hidden md:flex items-center gap-2 px-3 py-1 rounded-lg bg-[#f3f6fa] shadow-sm">
                        <i class="ph ph-user-circle text-[#b79a37] text-xl"></i>
                        <span class="text-gray-800">
                            <span class="font-semibold text-[#007bff]">{{ Auth::user()->name }}</span>
                        </span>
                        <div
                            class="bg-[#b79a37]/10 text-[#b79a37] px-3 py-1 rounded-full text-xs font-semibold tracking-wide shadow-sm">
                            {{ strtoupper(Auth::user()->getRoleNames()->first()) }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1 px-3 py-1 rounded-lg bg-white text-red-600 hover:bg-[#fbeaea] transition focus:outline-none focus:ring-2 focus:ring-[#b79a37] shadow-sm">
                            <i class="ph ph-sign-out text-lg"></i>
                            <span class="hidden sm:inline">Salir</span>
                        </button>
                    </form>
                </div>
                <!-- Botón Menú Móvil -->
                <div class="md:hidden">
                    <button id="mobileMenuToggle" aria-label="Abrir menú"
                        class="text-[#0c1c3c] focus:outline-none focus:ring-2 focus:ring-[#b79a37]">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </nav>
        <!-- Menú Móvil -->
        <div id="mobileMenu"
            class="md:hidden fixed top-16 left-0 w-full bg-white border-t border-[#e5e7eb] shadow-lg transition-all duration-300 ease-in-out transform -translate-y-4 opacity-0 pointer-events-none z-40">
            <div class="px-6 py-4 space-y-2 text-base">
                @role('SuperAdmin')
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                        <i class="ph ph-users-four text-[#b79a37] text-lg"></i> Usuarios
                    </a>
                    <a href="{{ route('referencias.index') }}"
                        class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                        <i class="ph ph-folder-open text-[#b79a37] text-lg"></i> Referencias
                    </a>
                    <a href="{{ route('referencias.admin') }}"
                        class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                        <i class="ph ph-list-magnifying-glass text-[#b79a37] text-lg"></i> Por Departamento
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                        <i class="ph ph-gauge text-[#b79a37] text-lg"></i> Dashboard
                    </a>
                @endrole
                @hasanyrole('GAF|GOR|GSEA|DE')
                    <a href="{{ route('referencias.index') }}"
                        class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                        <i class="ph ph-folder-user text-[#b79a37] text-lg"></i> Mis Referencias
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                        <i class="ph ph-gauge text-[#b79a37] text-lg"></i> Dashboard
                    </a>
                @endhasanyrole
                <a href="#" class="flex items-center gap-2 py-2 text-[#0c1c3c] hover:text-[#007bff] transition">
                    <i class="ph ph-question text-[#b79a37] text-lg"></i> Ayuda
                </a>
                <div class="border-t border-[#e5e7eb] pt-3 mt-2">
                    <span class="block text-gray-700 mb-2">Hola, <span
                            class="font-semibold text-[#007bff]">{{ Auth::user()->name }}</span></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-red-600 hover:underline transition focus:outline-none focus:ring-2 focus:ring-[#b79a37]">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
        @yield('content')
    </main>
    <footer class="bg-[#0c1c3c] border-t border-[#1a2d54] py-7 mt-12 text-sm text-gray-300 w-full shadow-inner">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center justify-center gap-3 text-center">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-[#b79a37]" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6l4 2m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    &copy; {{ date('Y') }}
                    <strong class="text-[#b79a37]">CCISur – REFSIS</strong>.
                    Todos los derechos reservados.
                </span>
            </div>
            <div class="flex items-center justify-center gap-2">
                <i class="ph ph-code text-[#b79a37] text-base"></i>
                <span>
                    Desarrollado por <strong class="text-[#b79a37]">José Hernandez</strong>
                </span>
            </div>
        </div>
    </footer>
    <script>
        const toggleBtn = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        let menuOpen = false;
        toggleBtn?.addEventListener('click', () => {
            menuOpen = !menuOpen;
            if (menuOpen) {
                mobileMenu.classList.remove('-translate-y-4', 'opacity-0', 'pointer-events-none');
                mobileMenu.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
            } else {
                mobileMenu.classList.add('-translate-y-4', 'opacity-0', 'pointer-events-none');
                mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
            }
        });
        // Cierra el menú móvil al hacer click fuera
        document.addEventListener('click', (e) => {
            if (menuOpen && !mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                mobileMenu.classList.add('-translate-y-4', 'opacity-0', 'pointer-events-none');
                mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                menuOpen = false;
            }
        });
    </script>
</body>

</html>
