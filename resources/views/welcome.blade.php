<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a REFSIS – CCISur</title>
    @vite('resources/css/app.css')
    <!-- Fuentes personalizadas -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#0c1c3c] text-white min-h-screen flex flex-col justify-between font-sans" style="font-family: 'Inter', sans-serif;">

    <!-- Fondo animado avanzado -->
    <div class="absolute inset-0 overflow-hidden z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0c1c3c]/90 via-[#1a2d54]/80 to-[#0c1c3c]/90"></div>
        
        <!-- Efecto de partículas avanzado -->
        <div id="particles-js" class="absolute inset-0 z-0"></div>
        
        <!-- Efecto de ondas sutil -->
        <div class="waves">
            <div class="wave wave-1"></div>
            <div class="wave wave-2"></div>
            <div class="wave wave-3"></div>
        </div>
    </div>

    <main class="relative z-10 flex-1 flex flex-col items-center justify-center px-4 py-8 sm:py-12">
        <!-- Logo con efecto de iluminación -->
        <div class="logo-container animate-fade-in-down" style="animation-delay: 0.1s;">
            <div class="logo-wrapper relative">
                <img src="{{ asset('storage/logos/logo2.png') }}" alt="Logo CCISur"
                     class="w-32 md:w-40 mx-auto mb-6 drop-shadow-lg transition-all duration-700 hover:scale-105 hover:drop-shadow-xl">
                <div class="logo-glow absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
        </div>

        <!-- Título con efecto de gradiente animado -->
        <div class="text-center mb-8 animate-fade-in-down" style="animation-delay: 0.2s;">
            <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-3">
                <span class="animated-gradient-text">REFSIS</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 font-light max-w-2xl mx-auto leading-relaxed">
                <span class="typing-animation">Plataforma de Gestión Documental Institucional</span>
            </p>
        </div>

        <!-- Botón de acceso con efecto de luz -->
        <div class="mt-12 animate-fade-in-up" style="animation-delay: 0.5s;">
            <a href="{{ route('login') }}"
               class="cta-button relative overflow-hidden group">
                <span class="absolute inset-0 bg-gradient-to-r from-[#b79a37] to-[#d4b24c] group-hover:from-[#d4b24c] group-hover:to-[#b79a37] transition-all duration-500"></span>
                <span class="light-effect absolute top-0 left-0 w-full h-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></span>
                <span class="relative z-10 flex items-center justify-center px-8 py-3 text-lg font-bold tracking-wide">
                    Iniciar Sesión
                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                </span>
            </a>
        </div>

        <!-- Tarjetas de características mejoradas -->
        <div class="w-full max-w-5xl mx-auto mt-8 grid gap-6 md:grid-cols-3 animate-fade-in-up" style="animation-delay: 0.3s;">
            <!-- Tarjeta 1 con efecto 3D -->
            <div class="feature-card transform transition-all duration-500 hover:-translate-y-3 hover:rotate-x-12">
                <div class="icon-container bg-gradient-to-br from-[#b79a37] to-[#d4b24c]">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mt-4 mb-2">Seguridad Integral</h3>
                <p class="text-gray-300 text-sm md:text-base">
                    Protección de datos con cifrado avanzado y autenticación multifactor para garantizar la confidencialidad.
                </p>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#b79a37] to-[#d4b24c] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            
            <!-- Tarjeta 2 con efecto 3D -->
            <div class="feature-card transform transition-all duration-500 hover:-translate-y-3 hover:rotate-x-12 delay-100">
                <div class="icon-container bg-gradient-to-br from-[#b79a37] to-[#d4b24c]">
                    <i class="fas fa-folder-tree text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mt-4 mb-2">Gestión Centralizada</h3>
                <p class="text-gray-300 text-sm md:text-base">
                    Control completo de referencias con historial de modificaciones y versionamiento documental.
                </p>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#b79a37] to-[#d4b24c] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            
            <!-- Tarjeta 3 con efecto 3D -->
            <div class="feature-card transform transition-all duration-500 hover:-translate-y-3 hover:rotate-x-12 delay-200">
                <div class="icon-container bg-gradient-to-br from-[#b79a37] to-[#d4b24c]">
                    <i class="fas fa-building text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mt-4 mb-2">¿Qué es REFSIS?</h3>
                <p class="text-gray-300 text-sm md:text-base">
                    Plataforma oficial de la Cámara de Comercio e Industrias del Sur para gestión, consulta y resguardo digital de referencias institucionales.
                </p>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#b79a37] to-[#d4b24c] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            
        </div>

        

        <!-- Efecto de conexión entre tarjetas -->
        <svg class="hidden md:block absolute z-0 w-full h-full top-0 left-0 pointer-events-none">
            <defs>
                <linearGradient id="line-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#b79a37" />
                    <stop offset="100%" stop-color="#d4b24c" />
                </linearGradient>
            </defs>
            <path class="connection-line" stroke="url(#line-gradient)" stroke-width="2" fill="none" stroke-dasharray="10,5"/>
        </svg>
    </main>

    <!-- Footer con efecto de desvanecimiento -->
    <footer class="relative z-10 w-full py-6 bg-gradient-to-t from-[#0c1c3c] via-[#0c1c3c]/90 to-transparent">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center justify-center">
            <p class="text-sm text-gray-400 text-center">
                © {{ now()->year }} CCISur – Todos los derechos reservados
            </p>
            </div>
        </div>
    </footer>

    <!-- Script para partículas avanzadas -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <!-- Estilos personalizados avanzados -->
    <style>
        /* Animaciones avanzadas */
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #d4b24c }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 1s cubic-bezier(0.215, 0.610, 0.355, 1.000) forwards;
        }
        
        .animate-fade-in-down {
            animation: fade-in-down 1s cubic-bezier(0.215, 0.610, 0.355, 1.000) forwards;
        }
        
        .animated-gradient-text {
            background: linear-gradient(90deg, #b79a37, #d4b24c, #f5d97e, #d4b24c, #b79a37);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradient-shift 6s ease infinite;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }
        
        .typing-animation {
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #d4b24c;
            animation: 
                typing 3.5s steps(40, end),
                blink-caret .75s step-end infinite;
        }
        
        /* Efecto de ondas */
        .waves {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            overflow: hidden;
            z-index: -1;
        }
        
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background-repeat: repeat no-repeat;
            background-position: 0 bottom;
            transform-origin: center bottom;
            opacity: 0.1;
        }
        
        .wave-1 {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' opacity='.25' fill='%23d4b24c'%3E%3C/path%3E%3C/svg%3E");
            animation: wave 18s linear infinite;
        }
        
        .wave-2 {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' opacity='.2' fill='%23b79a37'%3E%3C/path%3E%3C/svg%3E");
            animation: wave 16s linear reverse infinite;
            opacity: 0.15;
        }
        
        .wave-3 {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z' opacity='.15' fill='%23ffffff'%3E%3C/path%3E%3C/svg%3E");
            animation: wave 20s linear infinite;
            opacity: 0.1;
        }
        
        @keyframes wave {
            0% { transform: translateX(0) translateZ(0) scaleY(1); }
            50% { transform: translateX(-25%) translateZ(0) scaleY(0.8); }
            100% { transform: translateX(-50%) translateZ(0) scaleY(1); }
        }
        
        /* Logo con efecto de iluminación */
        .logo-wrapper {
            transition: all 0.5s ease;
        }
        
        .logo-glow {
            background: radial-gradient(circle, rgba(214,180,76,0.4) 0%, rgba(214,180,76,0) 70%);
            filter: blur(10px);
            transform: scale(1.1);
            z-index: -1;
            transition: all 0.7s ease;
        }
        
        .logo-wrapper:hover .logo-glow {
            opacity: 1;
            filter: blur(15px);
            transform: scale(1.2);
        }
        
        /* Tarjetas de características avanzadas */
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 28px;
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(214,180,76,0.1) 0%, rgba(214,180,76,0) 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: -1;
        }
        
        .feature-card:hover {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            transform: translateY(-10px) rotateX(12deg);
        }
        
        .feature-card:hover::before {
            opacity: 1;
        }
        
        .icon-container {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0c1c3c;
            box-shadow: 0 8px 20px rgba(183, 154, 55, 0.3);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .icon-container {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 25px rgba(183, 154, 55, 0.4);
        }
        
        /* Botón CTA avanzado */
        .cta-button {
            display: inline-flex;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(183, 154, 55, 0.5);
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            z-index: 1;
        }
        
        .light-effect {
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
            mix-blend-mode: overlay;
            pointer-events: none;
        }
        
        .cta-button:hover {
            box-shadow: 0 12px 30px rgba(183, 154, 55, 0.7);
            transform: translateY(-5px);
        }
        
        /* Efecto de conexión entre tarjetas */
        .connection-line {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: dash 10s linear forwards infinite;
            opacity: 0.3;
        }
        
        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>

    <!-- Configuración de partículas.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#d4b24c"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 2,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#b79a37",
                        "opacity": 0.3,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.8
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });

            // Dibujar líneas de conexión entre tarjetas
            const cards = document.querySelectorAll('.feature-card');
            const svg = document.querySelector('svg');
            const path = document.querySelector('.connection-line');
            
            if (cards.length === 3 && svg && path) {
                const updateConnections = () => {
                    const card1 = cards[0].getBoundingClientRect();
                    const card2 = cards[1].getBoundingClientRect();
                    const card3 = cards[2].getBoundingClientRect();
                    
                    const x1 = card1.left + card1.width / 2;
                    const y1 = card1.top + card1.height / 2;
                    
                    const x2 = card2.left + card2.width / 2;
                    const y2 = card2.top + card2.height / 2;
                    
                    const x3 = card3.left + card3.width / 2;
                    const y3 = card3.top + card3.height / 2;
                    
                    const pathData = `M${x1},${y1} Q${(x1+x2)/2},${(y1+y2)/2+50} ${x2},${y2} T${x3},${y3}`;
                    path.setAttribute('d', pathData);
                };
                
                window.addEventListener('load', updateConnections);
                window.addEventListener('resize', updateConnections);
            }
        });
    </script>
</body>
</html>
