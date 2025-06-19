<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REFSIS - CCISur</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="bg-[#f8fafc] text-gray-900 font-sans antialiased">
    <header class="bg-white shadow fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('storage/logos/logo.png') }}" alt="Logo"
                        class="h-10 w-10 rounded shadow border border-gray-200 bg-white">
                    <span class="text-2xl font-bold text-[#002c5f] tracking-tight select-none">REFSIS</span>
                </div>
                <nav class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    @role('SuperAdmin')
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition">
                            <i class="ph ph-users-four"></i> Usuarios
                        </a>
                        <a href="{{ route('referencias.index') }}"
                            class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition">
                            <i class="ph ph-folder-open"></i> Referencias
                        </a>
                        <a href="{{ route('referencias.admin') }}"
                            class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition">
                            <i class="ph ph-list-magnifying-glass"></i> Referencias por Departamento
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition">
                            <i class="ph ph-gauge"></i> Dashboard
                        </a>
                    @endrole

                    @hasanyrole('GAF|GOR|GSEA|DE')
                        <a href="{{ route('referencias.index') }}"
                            class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition"><i
                                class="ph ph-folder-user"></i> Mis Referencias</a>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition"><i
                                class="ph ph-gauge"></i> Dashboard</a>
                    @endhasanyrole
                    <a href="#" class="flex items-center gap-1 text-[#002c5f] hover:text-[#007bff] transition"><i
                            class="ph ph-question"></i> Ayuda</a>
                </nav>
                <div class="flex items-center space-x-4 text-sm">
                    <span class="hidden md:inline text-gray-700">Hola, <span
                            class="font-semibold text-[#007bff]">{{ Auth::user()->name }}</span></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline transition">Salir</button>
                    </form>
                </div>
                <div class="md:hidden">
                    <button id="mobileMenuToggle" class="text-[#002c5f] focus:outline-none">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t border-gray-200">
            <div class="px-4 py-3 space-y-2 text-sm">

                @role('SuperAdmin')
                    <a href="{{ route('admin.users.index') }}" class="block text-[#002c5f] hover:text-[#007bff]">
                        <i class="ph ph-users-four"></i> Usuarios
                    </a>
                    <a href="{{ route('referencias.index') }}" class="block text-[#002c5f] hover:text-[#007bff]">
                        <i class="ph ph-folder-open"></i> Referencias
                    </a>
                    <a href="{{ route('referencias.admin') }}" class="block text-[#002c5f] hover:text-[#007bff]">
                        <i class="ph ph-list-magnifying-glass"></i> Referencias por Departamento
                    </a>
                    <a href="{{ route('dashboard') }}" class="block text-[#002c5f] hover:text-[#007bff]">
                        <i class="ph ph-gauge"></i> Dashboard
                    </a>
                @endrole

                @hasanyrole('GAF|GOR|GSEA|DE')
                    <a href="{{ route('referencias.index') }}" class="block text-[#002c5f] hover:text-[#007bff]"><i
                            class="ph ph-folder-user"></i> Mis Referencias</a>
                    <a href="{{ route('dashboard') }}" class="block text-[#002c5f] hover:text-[#007bff]"><i
                            class="ph ph-gauge"></i> Dashboard</a>
                @endhasanyrole
                <a href="#" class="block text-[#002c5f] hover:text-[#007bff]"><i class="ph ph-question"></i>
                    Ayuda</a>
                <div class="border-t pt-2 mt-2">
                    <span class="block text-gray-700 mb-2">Hola, <span
                            class="font-semibold text-[#007bff]">{{ Auth::user()->name }}</span></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline transition">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
        @yield('content')
    </main>
    <footer class="text-center text-sm text-gray-500 py-6 border-t w-full fixed bottom-0 left-0 bg-white z-40">
        &copy; {{ date('Y') }} CCISur - REFSIS. Desarrollado por Jose H.
    </footer>
    <script>
        const toggleBtn = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        toggleBtn?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
