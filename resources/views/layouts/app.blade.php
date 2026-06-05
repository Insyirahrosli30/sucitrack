<!DOCTYPE html>
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

        <!-- Styles -->
        @livewireStyles
    </head>

    <body class="font-sans antialiased bg-gray-100">

        <div class="min-h-screen flex flex-col">

            <!-- NAVIGATION -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @include('layouts.navigation')
                </div>
            </header>

            <!-- PAGE HEADER -->
            @if (isset($header))
                <header class="bg-white border-b">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- PAGE CONTENT -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- FOOTER -->
            <footer class="bg-white border-t mt-auto">
                <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between text-sm text-gray-500">
                    <div>
                        © {{ date('Y') }} SuciTrack
                    </div>

                    <div>
                        Built for System Analysis & Design Project
                    </div>
                </div>
            </footer>

        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>