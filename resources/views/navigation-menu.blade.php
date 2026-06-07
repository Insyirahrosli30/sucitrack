<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">

    <!-- DEBUG (you can remove later) -->
    <div style="background:green;color:white;padding:6px 12px;font-size:12px;">
        NAVBAR LOADED SUCCESSFULLY
    </div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center space-x-8">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="font-bold text-lg gradient-text logo-font">
                    SuciTrack
                </a>

                <!-- LINKS -->
                <div class="hidden sm:flex sm:items-center sm:space-x-6">

                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link href="{{ route('qada.index') }}" :active="request()->routeIs('qada.*')">
                        Qada List
                    </x-nav-link>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">

                <span class="text-sm text-gray-600">
                    {{ Auth::user()->name }}
                </span>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:flex items-center">
                    @csrf

                    <button type="submit"
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-pink-300 to-purple-300 hover:from-pink-400 hover:to-purple-400 text-gray-800 font-semibold text-sm shadow-sm transition">
                        Logout
                    </button>
                </form>

            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('qada.index') }}" :active="request()->routeIs('qada.*')">
                Qada List
            </x-responsive-nav-link>

        </div>

    </div>

</nav>