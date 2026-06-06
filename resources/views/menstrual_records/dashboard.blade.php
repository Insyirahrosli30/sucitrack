<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-stone-50 min-h-screen font-sans">

    <nav class="bg-white border-b border-stone-100 px-6 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center space-x-2">
            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
            <span class="font-bold text-stone-800 tracking-tight">SuciTrack</span>
        </div>
        <div class="flex items-center space-x-6 text-sm font-medium text-stone-500">
            <a href="{{ route('calendar') }}" class="hover:text-stone-800 transition">Calendar</a>
            <a href="{{ route('menstrual_records.index') }}" class="hover:text-stone-800 transition">History & Records</a>
            <a href="{{ route('dashboard') }}" class="text-stone-900 border-b-2 border-stone-900 pb-1">Dashboard</a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                @csrf
                <button type="submit" class="hover:text-rose-600 transition cursor-pointer bg-transparent border-0 p-0 text-sm font-medium text-stone-500">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10 space-y-10">
        
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-stone-900 tracking-tight mb-1">Assalamualaikum, Sister</h1>
                <p class="text-xs text-stone-400">Overview of your ritual purity and tracking metrics.</p>
            </div>
            <div class="bg-white border border-stone-100 rounded-xl px-4 py-2 text-right shadow-sm">
                <span class="text-[10px] uppercase font-bold tracking-wider text-stone-400 block">Next Prayer</span>
                <span class="text-xs font-semibold text-stone-800">
                    {{ $labels[$nextPrayer] ?? $nextPrayer }} at {{ $prayer[$nextPrayer] ?? '--:--' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-stone-400 block mb-2">Days of Purity (Hari Suci)</span>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-4xl font-extrabold text-stone-900 tracking-tight">{{ $daysOfPurity }}</span>
                        <span class="text-sm text-stone-500">Days Clean</span>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $isClean ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        {{ $isClean ? 'Active Prayer State' : 'Menstruating State' }}
                    </span>
                </div>
            </div>

            <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-stone-400 block mb-2">Cycle Forecast Prediction</span>
                    <span id="dash-prediction-header" class="text-lg font-bold text-stone-800 block">
                        {{ $isClean ? 'In ' . (28 - $daysOfPurity) . ' Days' : 'Ongoing / Overdue' }}
                    </span>
                    <p id="dash-prediction-dates" class="text-xs text-stone-400 mt-1">Expected Window: {{ now()->addDays(5)->format('M d') }} – {{ now()->addDays(12)->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-stone-400 block mb-2">Unresolved Qada' Prayers</span>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-4xl font-extrabold text-stone-900 tracking-tight">{{ $pendingQadaCount }}</span>
                        <span class="text-sm text-stone-500">Prayers Owed</span>
                    </div>
                    <p class="text-xs text-stone-400 mt-1">Synced from live database logs</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h2 class="text-base font-bold text-stone-800 mb-1">Track Current Status</h2>
                    <p class="text-xs text-stone-400 mb-6">Log boundaries to update calculations.</p>
                    <a href="{{ route('menstrual_records.create') }}" class="w-full py-4 bg-white hover:bg-stone-50 border border-stone-200 text-stone-700 text-sm font-semibold rounded-xl transition shadow-sm flex items-center justify-center space-x-2 cursor-pointer">
                        <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                        <span>Log Period Boundary</span>
                    </a>
                </div>

                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h2 class="text-base font-bold text-stone-800 mb-1">Required Compensation Summary</h2>
                    <p class="text-xs text-stone-400 mb-4">Dynamic checklist summary predicted using Shafi'i jurisprudential rules.</p>
                    
                    <div id="qada-list-container" class="space-y-3">
                        @if(isset($finalFajrOwed) && $finalFajrOwed > 0)
                            <div class="flex items-center justify-between p-3 bg-stone-50 rounded-xl border border-stone-100">
                                <span class="text-sm font-medium text-stone-700">Subuh</span>
                                <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">Owed Count: {{ $finalFajrOwed }}</span>
                            </div>
                        @endif

                        @if(isset($finalZuhrOwed) && $finalZuhrOwed > 0)
                            <div class="flex items-center justify-between p-3 bg-stone-50 rounded-xl border border-stone-100">
                                <span class="text-sm font-medium text-stone-700">Zohor</span>
                                <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">Owed Count: {{ $finalZuhrOwed }}</span>
                            </div>
                        @endif

                        @if(isset($finalAsrOwed) && $finalAsrOwed > 0)
                            <div class="flex items-center justify-between p-3 bg-stone-50 rounded-xl border border-stone-100">
                                <span class="text-sm font-medium text-stone-700">Asar</span>
                                <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">Owed Count: {{ $finalAsrOwed }}</span>
                            </div>
                        @endif

                        @if(isset($finalMaghribOwed) && $finalMaghribOwed > 0)
                            <div class="flex items-center justify-between p-3 bg-stone-50 rounded-xl border border-stone-100">
                                <span class="text-sm font-medium text-stone-700">Maghrib</span>
                                <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">Owed Count: {{ $finalMaghribOwed }}</span>
                            </div>
                        @endif

                        @if(isset($finalIshaOwed) && $finalIshaOwed > 0)
                            <div class="flex items-center justify-between p-3 bg-stone-50 rounded-xl border border-stone-100">
                                <span class="text-sm font-medium text-stone-700">Isyak</span>
                                <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">Owed Count: {{ $finalIshaOwed }}</span>
                            </div>
                        @endif

                        @if($finalFajrOwed == 0 && $finalZuhrOwed == 0 && $finalAsrOwed == 0 && $finalMaghribOwed == 0 && $finalIshaOwed == 0)
                            <div class="text-center py-4 bg-emerald-50 rounded-xl border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-medium">Alhamdulillah, all calculated compensation obligations are fully settled!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-stone-800 mb-1">Mark Completed Prayers</h3>
                    <p class="text-xs text-stone-400 mb-4">Tick once fulfilled to safely resolve outstanding counts from your active profile record list.</p>
                  
                    <div id="qada-interactive-list" class="space-y-3">
                        @forelse($pendingQadaItems ?? [] as $item)
                            <div class="flex items-center justify-between p-3 bg-stone-50 rounded-xl border border-stone-100">
                                
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" 
                                           id="check-{{ $item->id }}" 
                                           class="w-5 h-5 rounded border-stone-300 text-rose-600 focus:ring-rose-500 cursor-pointer"
                                           onclick="toggleStrikeThrough('{{ $item->id }}')">
                                    
                                    <div id="text-block-{{ $item->id }}">
                                        <span class="text-sm font-medium text-stone-700 capitalize block">
                                            {{ $item->prayer_name == 'zuhr' ? 'Zohor' : ($item->prayer_name == 'isya' ? 'Isyak' : ucfirst($item->prayer_name)) }}
                                        </span>
                                        <span class="text-[10px] font-mono text-stone-400 block mt-0.5">
                                            {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : now()->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <form action="{{ route('dashboard.complete-qada', $item->id) }}" method="POST" class="inline m-0 p-0">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-stone-900 hover:bg-stone-800 rounded-lg shadow-sm cursor-pointer transition">
                                        Done
                                    </button>
                                </form>

                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-xs text-emerald-600 font-medium">Alhamdulillah, all pending qada' prayers have been cleared!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm space-y-3">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-stone-400 block">Tracking Configuration</span>
                    <div>
                        <span class="text-xs font-bold text-stone-400 block">API SYNC NODE</span>
                        <div class="flex items-center space-x-1.5 mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-md">Aladhan Live Engine Active</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        function toggleStrikeThrough(id) {
            const block = document.getElementById(`text-block-${id}`);
            const checkbox = document.getElementById(`check-${id}`);
            if (checkbox.checked) {
                block.classList.add('opacity-40', 'line-through');
            } else {
                block.classList.remove('opacity-40', 'line-through');
            }
        }
        
        window.menstrualRecords = @json($allRecords ?? []);
    </script>
</body>
</html>