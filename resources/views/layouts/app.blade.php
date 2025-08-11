<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REFSIS - CCISur</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #002c5f;
            --secondary-gold: #b79a37;
            --light-bg: #f8fafc;
            --dark-blue: #0c1c3c;
            --hover-blue: #007bff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .nav-item {
            position: relative;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--secondary-gold);
            transition: width 0.3s ease;
        }
        
        .nav-item:hover::after {
            width: 80%;
        }
        
        .nav-item.active::after {
            width: 80%;
            background: var(--hover-blue);
        }
        
        .user-badge {
            background: linear-gradient(135deg, rgba(183, 154, 55, 0.1) 0%, rgba(0, 44, 95, 0.1) 100%);
            border-left: 2px solid var(--secondary-gold);
        }
        
        .logout-btn {
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
        }
        
        .logout-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .logo-text {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .role-badge {
            background: linear-gradient(to right, var(--secondary-gold), #d4af37);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-[var(--light-bg)] text-gray-900 font-sans antialiased">
    <header class="bg-white shadow-sm fixed top-0 inset-x-0 z-50 border-b border-gray-100">
        <div class="max-w-8xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <!-- Logo y Título -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('storage/logos/logo3.png') }}" alt="Logo CCISur"
                            class="h-12 w-12 object-contain transition-transform duration-300 group-hover:scale-105" />
                        <span class="text-2xl font-bold tracking-tight logo-text">
                            <span class="text-[var(--primary-blue)]">REF</span><span class="text-[var(--secondary-gold)]">SIS</span>
                        </span>
                    </a>
                </div>

                <!-- Navegación Principal -->
                <nav class="hidden lg:flex items-center space-x-1">
                    @hasanyrole('SuperAdmin|Invitado')
                        <a href="{{ route('admin.roles.index') }}" class="nav-item flex items-center space-x-2 text-[var(--dark-blue)] hover:text-[var(--hover-blue)]">
                            <i class="ph ph-identification-card text-[var(--secondary-gold)] text-lg"></i>
                            <span>Roles / Departamentos</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center space-x-2 text-[var(--dark-blue)] hover:text-[var(--hover-blue)]">
                            <i class="ph ph-users-four text-[var(--secondary-gold)] text-lg"></i>
                            <span>Usuarios</span>
                        </a>
                        <a href="{{ route('referencias.admin') }}" class="nav-item flex items-center space-x-2 text-[var(--dark-blue)] hover:text-[var(--hover-blue)]">
                            <i class="ph ph-list-magnifying-glass text-[var(--secondary-gold)] text-lg"></i>
                            <span>Referencias</span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="nav-item flex items-center space-x-2 text-[var(--dark-blue)] hover:text-[var(--hover-blue)]">
                            <i class="ph ph-gauge text-[var(--secondary-gold)] text-lg"></i>
                            <span>Dashboard</span>
                        </a>
                    @endhasanyrole

                    @hasanyrole('GAF|GOR|GSEA|DE')
                        <a href="{{ route('referencias.index') }}" class="nav-item flex items-center space-x-2 text-[var(--dark-blue)] hover:text-[var(--hover-blue)]">
                            <i class="ph ph-folder-user text-[var(--secondary-gold)] text-lg"></i>
                            <span>Mis Referencias</span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="nav-item flex items-center space-x-2 text-[var(--dark-blue)] hover:text-[var(--hover-blue)]">
                            <i class="ph ph-gauge text-[var(--secondary-gold)] text-lg"></i>
                            <span>Dashboard</span>
                        </a>
                    @endhasanyrole
                </nav>

                <!-- Área de Usuario -->
                <div class="hidden lg:flex items-center space-x-4">
                    <div class="user-badge flex items-center space-x-3 px-4 py-2 rounded-lg">
                        <div class="relative">
                            <i class="ph ph-user-circle text-[var(--secondary-gold)] text-2xl"></i>
                            <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-[var(--dark-blue)]">{{ Auth::user()->name }}</span>
                            <span class="text-xs role-badge">
                                {{ strtoupper(Auth::user()->getRoleNames()->first()) }}
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn flex items-center space-x-1 px-4 py-2 bg-white text-red-600 rounded-lg hover:bg-red-50 transition-all">
                            <i class="ph ph-sign-out text-lg"></i>
                            <span class="font-medium">Salir</span>
                        </button>
                    </form>
                </div>

                <!-- Menú Mobile (oculto en desktop) -->
                <div class="lg:hidden">
                    <button id="mobileMenuToggle" class="text-[var(--dark-blue)] p-2 rounded-lg hover:bg-gray-100">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-8xl mx-auto px-6 pt-28 pb-16">
        @yield('content')
    </main>

    <footer class="bg-[var(--dark-blue)] py-8 mt-12 text-sm text-gray-300 w-full">
        <div class="max-w-8xl mx-auto px-6 flex flex-col items-center justify-center gap-4 text-center">
            <div class="flex items-center justify-center gap-3">
                <svg class="w-5 h-5 text-[var(--secondary-gold)]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    &copy; {{ date('Y') }} <strong class="text-[var(--secondary-gold)]">CCISur – REFSIS</strong>. Todos los derechos reservados.
                </span>
            </div>
            <div class="flex items-center justify-center gap-2">
                <i class="ph ph-code text-[var(--secondary-gold)] text-base"></i>
                <span>
                    Desarrollado por <strong class="text-[var(--secondary-gold)]">José Hernandez</strong>
                </span>
            </div>
        </div>
    </footer>

    <script>
        // Menú móvil (mantenido por si acaso, aunque el enfoque es desktop)
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
        
        // Efecto hover mejorado para elementos de navegación
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-2px)';
            });
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>