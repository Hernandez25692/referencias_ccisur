<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a REFSIS – CCISur</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#0c1c3c] text-white min-h-screen flex flex-col justify-between">

    <!-- Fondo decorativo diagonal -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="hidden md:block absolute top-0 left-0 w-full h-1/2 bg-gradient-to-br from-[#0c1c3c] via-[#1a2d54] to-transparent opacity-80"
             style="clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);"></div>
        <div class="absolute bottom-0 right-0 w-full h-1/3 bg-gradient-to-tr from-[#b79a37]/20 to-transparent opacity-60"
             style="clip-path: polygon(0 0, 100% 30%, 100% 100%, 0 100%);"></div>
    </div>

    <main class="relative z-10 flex-1 flex flex-col items-center justify-center px-4 py-8">
        <!-- Logo -->
        <img src="{{ asset('storage/logos/logo2.png') }}" alt="Logo CCISur"
             class="w-28 md:w-36 mx-auto mb-6 drop-shadow-lg animate-fade-in-up" style="animation-delay: 0.1s;">

        <!-- Título y subtítulo -->
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide mb-2 font-sans animate-fade-in-up"
            style="animation-delay: 0.2s;">
            <span class="text-[#b79a37]">REFSIS</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-200 mb-6 font-light animate-fade-in-up"
           style="animation-delay: 0.3s;">
            Sistema de Gestión de Referencias Institucionales
        </p>

        <!-- Sección animada de descripción y ventajas -->
        <section class="w-full max-w-3xl mx-auto mt-4 grid gap-8 md:grid-cols-2 items-center animate-fade-in-up"
                 style="animation-delay: 0.4s;">
            <!-- Descripción breve -->
            <div class="backdrop-blur-md bg-white/5 rounded-2xl shadow-lg p-6 md:p-8 border border-white/10 transition hover:shadow-2xl hover:bg-white/10 duration-300">
                <h2 class="text-xl font-semibold mb-2 text-[#b79a37]">¿Qué es REFSIS?</h2>
                <p class="text-gray-200 text-base">
                    REFSIS es la plataforma oficial de la Cámara de Comercio e Industrias del Sur para la gestión, consulta y resguardo digital de referencias institucionales, garantizando seguridad, eficiencia y trazabilidad.
                </p>
            </div>
            <!-- Ventajas -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 backdrop-blur-md bg-white/5 rounded-xl p-4 border border-white/10 shadow transition hover:bg-white/10 duration-300">
                    <div class="bg-[#b79a37]/90 rounded-full p-2 shadow text-[#0c1c3c]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                             d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 0V7m0 4v4m0 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/></svg>
                    </div>
                    <span class="text-base text-gray-100 font-medium">Acceso seguro</span>
                </div>
                <div class="flex items-center gap-3 backdrop-blur-md bg-white/5 rounded-xl p-4 border border-white/10 shadow transition hover:bg-white/10 duration-300">
                    <div class="bg-[#b79a37]/90 rounded-full p-2 shadow text-[#0c1c3c]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                             d="M8 17l4 4 4-4m-4-5v9"/></svg>
                    </div>
                    <span class="text-base text-gray-100 font-medium">Historial digital</span>
                </div>
                <div class="flex items-center gap-3 backdrop-blur-md bg-white/5 rounded-xl p-4 border border-white/10 shadow transition hover:bg-white/10 duration-300">
                    <div class="bg-[#b79a37]/90 rounded-full p-2 shadow text-[#0c1c3c]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                             d="M3 7h18M3 12h18M3 17h18"/></svg>
                    </div>
                    <span class="text-base text-gray-100 font-medium">Gestión por departamento</span>
                </div>
            </div>
        </section>

        <!-- Botón de acceso -->
        <div class="mt-10 animate-fade-in-up" style="animation-delay: 0.5s;">
            <a href="{{ route('login') }}"
               class="inline-block bg-[#b79a37] hover:bg-[#d4b24c] text-[#0c1c3c] font-bold px-8 py-3 rounded-full shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#b79a37]/60 focus:ring-offset-2 text-lg tracking-wide">
                Iniciar sesión
            </a>
        </div>
    </main>

    <!-- Footer institucional -->
    <footer class="relative z-10 w-full text-center py-4 text-sm text-gray-300 bg-transparent mt-8">
        © CCISur – Todos los derechos reservados – REFSIS {{ now()->year }}
    </footer>

    <!-- Animaciones personalizadas -->
    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(40px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s cubic-bezier(.4,0,.2,1) both;
        }
    </style>
</body>
</html>
