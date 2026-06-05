<nav class="bg-white border-b border-stone-100 sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
            <span class="font-bold text-base tracking-tight text-stone-800">SuciTrack</span>
        </a>
        
        <div class="flex items-center space-x-6 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-stone-800 border-b-2 border-stone-800 py-5' : 'text-stone-400 hover:text-stone-800 transition py-5' }}">
                Dashboard
            </a>
            <a href="{{ route('menstrual_records.index') }}" class="{{ request()->routeIs('menstrual_records.*') ? 'text-stone-800 border-b-2 border-stone-800 py-5' : 'text-stone-400 hover:text-stone-800 transition py-5' }}">
                History & Logs
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-stone-400 hover:text-rose-600 transition text-sm font-medium pl-2">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>