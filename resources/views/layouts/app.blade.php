<!DOCTYPE html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
=======
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referencias CCISur</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900">

    <header class="bg-white shadow-md fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="text-xl font-bold text-blue-900">
                <a href="{{ url('/') }}">REFERENCIAS CCISur</a>
            </div>
            <div>
                <span class="text-sm mr-4">Hola, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>

    <div class="flex pt-20 min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r hidden md:block">
            <nav class="p-4">
                <ul class="space-y-2">
                    @role('SuperAdmin')
                        <li><a href="{{ route('admin.users.index') }}" class="block p-2 rounded hover:bg-blue-100">Gestión
                                de Usuarios</a></li>
                        <li><a href="{{ route('referencias.index') }}"
                                class="block p-2 rounded hover:bg-blue-100">Referencias Generales</a></li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-blue-100">Dashboard</a>
                        </li>
                    @endrole


                    @hasanyrole('GAF|GOR|GSEA|DE')
                        <li>
                            <a href="{{ route('referencias.index') }}" class="block p-2 rounded hover:bg-blue-100">
                                Mis Referencias
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-blue-100">Dashboard</a>
                        </li>
                    @endhasanyrole


                    <li><a href="#" class="block p-2 rounded hover:bg-blue-100">Ayuda</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>

>>>>>>> recuperar-trabajo
</html>
