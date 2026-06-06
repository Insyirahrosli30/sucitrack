<nav class="bg-pink-100 border-b border-pink-200">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

        <div class="font-bold text-pink-700">
            SuciTrack
        </div>

        <div class="flex gap-6 text-sm">

            <a href="{{ route('dashboard') }}"
               class="{{ request()->is('dashboard') ? 'text-pink-700 font-semibold' : 'text-gray-500 hover:text-pink-700' }}">
                Dashboard
            </a>

            <a href="{{ route('menstrual_records.index') }}"
               class="{{ request()->is('menstrual_records*') ? 'text-pink-700 font-semibold' : 'text-gray-500 hover:text-pink-700' }}">
                History & Records
            </a>

            <a href="{{ route('qada.index') }}"
               class="{{ request()->is('qada*') ? 'text-pink-700 font-semibold' : 'text-gray-500 hover:text-pink-700' }}">
                Qada' List
            </a>

        </div>

    </div>
</nav>