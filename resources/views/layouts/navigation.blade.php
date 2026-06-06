<nav class="flex items-center justify-between w-full text-sm font-medium text-gray-700">

    <!-- LEFT BRAND -->
    <div class="font-semibold text-pink-700 text-lg">
        SuciTrack
    </div>

    <!-- CENTER LINKS -->
    <div class="flex items-center gap-6">

        <a href="{{ url('/menstrual_records') }}"
           class="hover:text-pink-700 transition">
            SuciTrack
        </a>

        <a href="{{ route('dashboard') }}"
           class="hover:text-pink-700 transition">
            Dashboard
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

    <!-- RIGHT SIDE (keep auth system working) -->
    <div>
        @auth
            <span class="text-gray-500 text-xs">
                {{ Auth::user()->name }}
            </span>
        @endauth
    </div>

</nav>