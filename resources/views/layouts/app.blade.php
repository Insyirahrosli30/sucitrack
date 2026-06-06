<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SuciTrack') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Optional font -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>

    <body class="font-sans antialiased bg-gradient-to-br from-pink-50 to-pink-100">

        <div class="min-h-screen flex flex-col">

            <!-- NAVIGATION -->
            <header class="bg-pink-200 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <nav class="flex items-center justify-between py-4 text-sm font-medium text-gray-700">

                        <!-- BRAND -->
                        <div class="font-semibold text-pink-700 text-lg">
                            SuciTrack
                        </div>

                        <!-- MENU -->
                        <div class="flex gap-6">

                            <a href="{{ route('dashboard') }}"
                               class="hover:text-pink-700 transition">
                                Dashboard
                            </a>

                            <a href="{{ url('/menstrual_records') }}"
                               class="hover:text-pink-700 transition">
                                SuciTrack
                            </a>

                            <a href="{{ url('/history') }}"
                               class="hover:text-pink-700 transition">
                                History & Records
                            </a>

                            <a href="{{ url('/qada') }}"
                               class="hover:text-pink-700 transition">
                                Qada' List
                            </a>

                        </div>

                        <!-- AUTH (KEEP THIS - IMPORTANT) -->
                        <div>
                            @include('layouts.navigation')
                        </div>

                    </nav>

                </div>
            </header>

            <!-- PAGE HEADER -->
            @if (isset($header))
                <header class="bg-pink-100 border-b">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- CONTENT -->
            <main class="flex-1 bg-pink-50/40">
                {{ $slot }}
            </main>

            <!-- FOOTER -->
            <footer class="bg-pink-100 border-t mt-auto">
                <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between text-sm text-gray-600">
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