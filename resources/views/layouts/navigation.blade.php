<nav class="bg-white/60 backdrop-blur-md border-b border-pink-100 shadow-sm">

    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

        <!-- LOGO -->
        <div class="flex items-center gap-2">

            <span class="text-pink-500 text-xl">
                ☾
            </span>

            <span class="logo-font text-xl font-bold gradient-text">
                SUCITRACK
            </span>

        </div>

        <!-- MENU -->
        <div class="flex items-center gap-3">

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 rounded-xl transition
               {{ request()->is('dashboard')
                    ? 'bg-gradient-to-r from-pink-400 to-purple-400 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-white/70' }}">
                Dashboard
            </a>

            <a href="{{ route('menstrual_records.index') }}"
               class="px-4 py-2 rounded-xl transition
               {{ request()->is('menstrual_records*')
                    ? 'bg-gradient-to-r from-pink-400 to-purple-400 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-white/70' }}">
                History & Records
            </a>

            <a href="{{ route('qada.index') }}"
               class="px-4 py-2 rounded-xl transition
               {{ request()->is('qada*')
                    ? 'bg-gradient-to-r from-pink-400 to-purple-400 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-white/70' }}">
                Qada' List
            </a>

            <!-- LOGOUT (OPTION 2) -->
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-xl text-red-500 hover:bg-red-50 transition">
                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>