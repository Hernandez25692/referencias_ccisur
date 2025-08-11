<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Error') | REFSIS - CCISur</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="/favicon.ico">
</head>

<body class="h-full bg-[#f8fafc] text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-10">
        {{-- Header/Logo --}}
        <div class="mb-8 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#002c5f] flex items-center justify-center">
                <span class="text-white font-bold">CC</span>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-[#002c5f] leading-tight">Cámara de Comercio e Industria del Sur
                </h1>
                <p class="text-xs text-gray-500 -mt-1">Sistema de Referencias (REFSIS)</p>
            </div>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-gray-100">
            <div class="p-8">
                <div class="flex items-center gap-4 mb-5">
                    <div
                        class="flex items-center justify-center w-14 h-14 rounded-2xl bg-[#f3f6fa] border border-[#e5e7eb]">
                        {{-- Ícono genérico (emoji) – puedes cambiar por SVG si quieres --}}
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-widest text-[#b79a37] uppercase">@yield('code')</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0c1c3c]">@yield('title')</h2>
                    </div>
                </div>

                <p class="text-gray-600 leading-relaxed">@yield('message')</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @yield('actions')
                </div>
            </div>

            <div
                class="px-8 py-5 bg-[#f9fafb] rounded-b-2xl border-t border-[#eef2f7] text-xs text-gray-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <span>Si el problema persiste, contacta a <strong class="text-gray-700">Soporte</strong>.</span>
                <span>Ref: <span class="font-mono">{{ now()->format('Y-m-d H:i:s') }}</span></span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-xs text-gray-500">
            &copy; {{ date('Y') }} CCISur. Todos los derechos reservados.
        </div>
    </div>
</body>

</html>
