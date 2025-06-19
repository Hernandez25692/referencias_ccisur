<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login – REFSIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0c1c3c 60%, #1a2a4f 100%);
            position: relative;
            overflow: hidden;
        }
        /* Abstract gold shapes */
        .gold-shape {
            position: absolute;
            border-radius: 9999px;
            filter: blur(18px);
            opacity: 0.25;
            z-index: 0;
            pointer-events: none;
            animation: float 8s ease-in-out infinite alternate;
        }
        .gold-shape1 {
            width: 320px; height: 120px; top: -60px; left: -80px;
            background: linear-gradient(90deg, #b79a37 60%, #fffbe6 100%);
            animation-delay: 0s;
        }
        .gold-shape2 {
            width: 180px; height: 180px; bottom: 40px; right: -60px;
            background: linear-gradient(120deg, #b79a37 80%, #fffbe6 100%);
            animation-delay: 2s;
        }
        .gold-shape3 {
            width: 120px; height: 60px; top: 60%; left: 10%;
            background: linear-gradient(60deg, #b79a37 80%, #fffbe6 100%);
            animation-delay: 4s;
        }
        @keyframes float {
            0% { transform: translateY(0) scale(1);}
            100% { transform: translateY(-20px) scale(1.05);}
        }
        /* Glassmorphism card */
        .glass-card {
            background: rgba(20, 32, 60, 0.65);
            box-shadow: 0 8px 32px 0 rgba(12,28,60,0.25), 0 1.5px 8px 0 #b79a3722;
            backdrop-filter: blur(12px) saturate(140%);
            -webkit-backdrop-filter: blur(12px) saturate(140%);
            border-radius: 1.5rem;
            border: 1.5px solid rgba(183,154,55,0.18);
            z-index: 1;
        }
        /* Animations for card */
        .fade-in {
            animation: fadeInUp 1s cubic-bezier(.39,.575,.565,1) both;
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px);}
            100% { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen font-sans relative">

    <!-- Abstract gold shapes -->
    <div class="gold-shape gold-shape1"></div>
    <div class="gold-shape gold-shape2"></div>
    <div class="gold-shape gold-shape3"></div>

    <!-- Orbiting animated shapes around the card -->
    <div class="absolute inset-0 pointer-events-none z-10">
        <!-- Top left orbiting shape -->
        <div class="orbit-shape orbit-shape1"></div>
        <!-- Bottom right orbiting shape -->
        <div class="orbit-shape orbit-shape2"></div>
        <!-- Top right orbiting shape -->
        <div class="orbit-shape orbit-shape3"></div>
    </div>

    <div class="relative flex items-center justify-center w-full max-w-md z-30">
        <!-- Glowing border effect -->
        <div class="absolute inset-0 pointer-events-none z-40">
            <span class="glow-border"></span>
        </div>
        <div class="glass-card w-full max-w-md p-8 md:p-10 fade-in relative z-50 shadow-2xl border-2 border-[#b79a37]/30">
            <div class="flex flex-col items-center mb-7">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/logos/logo1.png') }}" alt="Logo CCISUR" class="w-32 md:w-40 mb-3 drop-shadow-lg transition-transform hover:scale-105">
                </a>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-wide mb-1 drop-shadow-sm">REFSIS</h1>
                <p class="text-base md:text-lg text-[#b79a37] font-medium mb-1 tracking-wide">Sistema de Referencias Documentales</p>
                <p class="text-xs text-gray-200 text-center">Cámara de Comercio e Industrias del Sur</p>
            </div>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-400 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Correo -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-200 mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full bg-[#0c1c3c]/60 border border-[#b79a37]/40 text-white placeholder-gray-400 rounded-lg shadow-sm focus:ring-[#b79a37] focus:border-[#b79a37] transition duration-200 px-4 py-2.5 outline-none"
                        placeholder="usuario@ccisur.org">
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-200 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full bg-[#0c1c3c]/60 border border-[#b79a37]/40 text-white placeholder-gray-400 rounded-lg shadow-sm focus:ring-[#b79a37] focus:border-[#b79a37] transition duration-200 px-4 py-2.5 outline-none"
                        placeholder="••••••••">
                </div>

                <!-- Recordar y Olvidaste -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center select-none">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-400 text-[#b79a37] shadow-sm focus:ring-[#b79a37] accent-[#b79a37] transition duration-150">
                        <span class="ml-2 text-sm text-gray-200">Recordarme</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#b79a37] hover:underline transition" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#b79a37] via-[#ffe9a0] to-[#b79a37] text-[#0c1c3c] font-bold py-2.5 px-4 rounded-lg shadow-lg hover:bg-[#a88a2e] hover:scale-[1.03] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#b79a37]/60 focus:ring-offset-2">
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
        <!-- Glowing border CSS -->
        <style>
            .glow-border {
                position: absolute;
                inset: 0;
                border-radius: 1.5rem;
                box-shadow:
                    0 0 16px 4px #ffe9a0cc,
                    0 0 32px 8px #b79a37cc,
                    0 0 48px 16px #b79a3733;
                border: 2.5px solid #ffe9a0;
                opacity: 0.85;
                pointer-events: none;
                z-index: 2;
                animation: glowPulse 2.5s ease-in-out infinite alternate;
            }
            @keyframes glowPulse {
                0% { box-shadow: 0 0 16px 4px #ffe9a0cc, 0 0 32px 8px #b79a37cc, 0 0 48px 16px #b79a3733; }
                100% { box-shadow: 0 0 32px 8px #ffe9a0ee, 0 0 48px 16px #b79a37ee, 0 0 64px 24px #b79a3755; }
            }
            @media (max-width: 640px) {
                .glow-border {
                    border-radius: 1rem;
                }
            }
        </style>
    </div>

    <!-- Orbiting shapes CSS -->
    <style>
        .orbit-shape {
            position: absolute;
            border-radius: 9999px;
            opacity: 0.35;
            pointer-events: none;
            z-index: 10;
            filter: blur(4px);
        }
        .orbit-shape1 {
            width: 60px; height: 60px;
            top: -40px; left: -40px;
            background: linear-gradient(135deg, #b79a37 60%, #fffbe6 100%);
            animation: orbit1 7s linear infinite;
        }
        .orbit-shape2 {
            width: 80px; height: 80px;
            bottom: -50px; right: -50px;
            background: linear-gradient(135deg, #fffbe6 60%, #b79a37 100%);
            animation: orbit2 9s linear infinite;
        }
        .orbit-shape3 {
            width: 40px; height: 40px;
            top: -30px; right: -30px;
            background: linear-gradient(135deg, #b79a37 80%, #fffbe6 100%);
            animation: orbit3 6s linear infinite;
        }
        @keyframes orbit1 {
            0% { transform: translate(0, 0);}
            25% { transform: translate(40px, 60px);}
            50% { transform: translate(80px, 0);}
            75% { transform: translate(40px, -60px);}
            100% { transform: translate(0, 0);}
        }
        @keyframes orbit2 {
            0% { transform: translate(0, 0);}
            20% { transform: translate(-60px, -40px);}
            50% { transform: translate(-120px, 0);}
            80% { transform: translate(-60px, 40px);}
            100% { transform: translate(0, 0);}
        }
        @keyframes orbit3 {
            0% { transform: translate(0, 0);}
            33% { transform: translate(-30px, 40px);}
            66% { transform: translate(30px, 40px);}
            100% { transform: translate(0, 0);}
        }
        @media (max-width: 640px) {
            .orbit-shape1 { width: 30px; height: 30px; top: -20px; left: -20px;}
            .orbit-shape2 { width: 40px; height: 40px; bottom: -25px; right: -25px;}
            .orbit-shape3 { width: 20px; height: 20px; top: -15px; right: -15px;}
        }
    </style>

    <!-- Responsive adjustments -->
    <style>
        @media (max-width: 640px) {
            .glass-card { padding: 1.5rem !important; }
            .gold-shape1 { width: 180px; height: 60px; top: -30px; left: -40px;}
            .gold-shape2 { width: 100px; height: 100px; bottom: 10px; right: -30px;}
            .gold-shape3 { width: 60px; height: 30px; top: 70%; left: 5%;}
        }
    </style>
</body>
</html>
