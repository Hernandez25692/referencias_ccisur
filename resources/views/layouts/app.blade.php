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
            --primary: #1e293b;
            --accent: #FFD700; /* Cambiado a dorado */
            --bg: #f1f5f9;
            --white: #fff;
            --shadow: 0 2px 12px 0 rgba(30,41,59,0.08);
        }
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(8px);
            box-shadow: var(--shadow);
        }
        .nav-modern {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 72px;
            border-radius: 1.5rem;
            margin: 1.5rem auto 0 auto;
            max-width: 1200px;
            position: relative;
        }
        .nav-modern .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -1px;
        }
        .nav-modern .logo span {
            color: var(--accent);
        }
        .nav-modern .nav-links {
            display: flex;
            gap: 1.5rem;
        }
        .nav-modern .nav-link {
            position: relative;
            font-size: 1rem;
            color: var(--primary);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-modern .nav-link.active,
        .nav-modern .nav-link:hover {
            background: var(--accent);
            color: var(--white);
        }
        .nav-modern .user-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .nav-modern .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: 0 2px 8px 0 rgba(255,215,0,0.15); /* Cambiado a dorado */
        }
        .nav-modern .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .nav-modern .user-info .name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary);
        }
        .nav-modern .user-info .role {
            font-size: 0.8rem;
            color: var(--accent);
            font-weight: 500;
            letter-spacing: 1px;
        }
        .nav-modern .logout-btn {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .nav-modern .logout-btn:hover {
            background: #fff8dc; /* Un dorado claro */
            color: #ef4444;
        }
        /* Mobile */
        @media (max-width: 900px) {
            .nav-modern {
                flex-wrap: wrap;
                height: auto;
                padding: 1rem;
            }
            .nav-modern .nav-links {
                display: none;
                flex-direction: column;
                gap: 1rem;
                position: absolute;
                top: 72px;
                left: 0;
                width: 100%;
                background: rgba(255,255,255,0.95);
                border-radius: 0 0 1.5rem 1.5rem;
                box-shadow: var(--shadow);
                z-index: 20;
            }
            .nav-modern .nav-links.open {
                display: flex;
            }
            .nav-modern .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                background: none;
                border: none;
                font-size: 2rem;
                color: var(--primary);
                cursor: pointer;
                margin-left: 1rem;
            }
        }
        @media (min-width: 901px) {
            .nav-modern .menu-toggle {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-[var(--bg)] text-gray-900 font-sans antialiased min-h-screen">
    <header>
        <nav class="nav-modern glass">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('storage/logos/logo3.png') }}" alt="Logo" class="h-10 w-10 object-contain" />
                <span>REFSIS</span>
            </a>
            <!-- Menu Toggle (Mobile) -->
            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <i class="ph ph-list"></i>
            </button>
            <!-- Links -->
            <div class="nav-links" id="navLinks">
                @hasanyrole('SuperAdmin|Invitado')
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="ph ph-identification-card"></i> Roles
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="ph ph-users-four"></i> Usuarios
                    </a>
                    <a href="{{ route('referencias.admin') }}" class="nav-link {{ request()->routeIs('referencias.admin') ? 'active' : '' }}">
                        <i class="ph ph-list-magnifying-glass"></i> Referencias
                    </a>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="ph ph-gauge"></i> Dashboard
                    </a>
                @endhasanyrole
                @hasanyrole('GAF|GOR|GSEA|DE')
                    <a href="{{ route('referencias.index') }}" class="nav-link {{ request()->routeIs('referencias.index') ? 'active' : '' }}">
                        <i class="ph ph-folder-user"></i> Mis Referencias
                    </a>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="ph ph-gauge"></i> Dashboard
                    </a>
                @endhasanyrole
            </div>
            <!-- User Area -->
            <div class="user-area">
                <div class="user-avatar">
                    <i class="ph ph-user"></i>
                </div>
                <div class="user-info">
                    <span class="name">{{ Auth::user()->name }}</span>
                    <span class="role">{{ strtoupper(Auth::user()->getRoleNames()->first()) }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Salir">
                        <i class="ph ph-sign-out"></i>
                    </button>
                </form>
            </div>
        </nav>
    </header>
    <main class="max-w-7xl mx-auto px-4 pt-12 pb-16">
        @yield('content')
    </main>
    <footer class="bg-[var(--primary)] py-8 mt-12 text-sm text-gray-300 w-full">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center justify-center gap-4 text-center">
            <div class="flex items-center justify-center gap-3">
                <svg class="w-5 h-5 text-[var(--accent)]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    &copy; {{ date('Y') }} <strong class="text-[var(--accent)]">CCISur – REFSIS</strong>. Todos los derechos reservados.
                </span>
            </div>
            <div class="flex items-center justify-center gap-2">
                <i class="ph ph-code text-[var(--accent)] text-base"></i>
                <span>
                    Desarrollado por <strong class="text-[var(--accent)]">José Hernandez</strong>
                </span>
            </div>
        </div>
    </footer>
    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        menuToggle?.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });
        // Cierra el menú al hacer click fuera (opcional)
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
                navLinks.classList.remove('open');
            }
        });
    </script>
</body>
</html>