<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Plus+Jakarta+Sans:wght=400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FBFBFA] text-[#1F2937] antialiased min-h-screen">

    <nav class="bg-white border-b border-stone-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
                <span class="font-bold text-base tracking-tight text-stone-800">SuciTrack</span>
            </div>
            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('calendar') }}" class="text-stone-400 hover:text-stone-800 transition px-1 py-5">Calendar</a>
                <a href="{{ route('menstrual_records.index') }}" class="text-stone-400 hover:text-stone-800 transition px-1 py-5">History & Records</a>
                <a href="{{ route('dashboard') }}" class="text-stone-800 border-b-2 border-stone-800 px-1 py-5 transition">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-stone-400 hover:text-rose-600 font-medium text-sm transition pl-2">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CLEAN DATA BRIDGE -->
    <script>
        window.menstrualRecords = {!! $allRecords->toJson() !!};
        window.jakimPrayerTimes = {
            fajr: "{{ $prayer['Fajr'] }}:00",
            zohor: "{{ $prayer['Dhuhr'] }}:00",
            asar: "{{ $prayer['Asr'] }}:00",
            maghrib: "{{ $prayer['Maghrib'] }}:00",
            isyak: "{{ $prayer['Isha'] }}:00"
        };
    </script>

    <main class="max-w-5xl mx-auto px-6 py-10">
        <div class="border-b border-stone-100 pb-6 mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-stone-900 tracking-tight">Assalamualaikum, Sister</h1>
                <p class="text-sm text-stone-400 mt-1">Overview of your ritual purity and tracking metrics.</p>
            </div>
            <div class="bg-stone-50 border border-stone-200 px-4 py-2.5 rounded-xl text-xs font-medium text-stone-600">
                Next Prayer: <span class="font-bold text-stone-800">{{ $labels[$nextPrayer] }}</span> at <span class="font-mono text-stone-800">{{ $prayer[$nextPrayer] }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Days of Purity (Hari Suci)</p>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-3xl font-bold text-stone-800">{{ $isClean ? $daysOfPurity : 0 }}</span>
                    <span class="text-sm text-stone-400 font-medium">Days Clean</span>
                </div>
                @if($isClean)
                    <p class="text-xs text-emerald-600 mt-2 bg-emerald-50 inline-block px-2 py-0.5 rounded-md font-medium">Active Prayer State</p>
                @else
                    <p class="text-xs text-rose-600 mt-2 bg-rose-50 inline-block px-2 py-0.5 rounded-md font-medium">In Menstrual State</p>
                @endif
            </div>

            <div class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Cycle Forecast Prediction</p>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span id="dash-prediction-header" class="text-xl font-bold text-stone-800">Calculating...</span>
                </div>
                <p id="dash-prediction-dates" class="text-xs text-stone-400 mt-3 font-medium">Checking recent entries...</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Unresolved Qada' Prayers</p>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-3xl font-bold text-stone-800">{{ $pendingQadaCount }}</span>
                    <span class="text-sm text-stone-400 font-medium">Prayers Owed</span>
                </div>
                <p class="text-xs text-stone-400 mt-2 font-medium">Synced from live database logs</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-800">Track Current Status</h2>
                    <p class="text-sm text-stone-400 mt-1 mb-6">Log boundaries to update calculations.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('menstrual_records.create') }}" class="flex-1 inline-flex items-center justify-center px-5 py-4 border border-stone-200 rounded-xl text-sm font-medium text-stone-700 bg-white hover:bg-stone-50 transition">
                            <span class="w-2 h-2 rounded-full bg-rose-400 mr-3 animate-pulse"></span>
                            Log Period Boundary
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h2 class="text-base font-bold text-stone-800 mb-1">Required Compensation List</h2>
                    <p class="text-xs text-stone-400 mb-4">Calculated using Shafi'i jurisprudential rules.</p>
                    <div id="qada-list-container" class="space-y-3"></div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-stone-800 mb-4">Tracking Configuration</h3>
                    <div>
                        <label class="block text-xs font-medium text-stone-400 uppercase tracking-wider">API Sync Node</label>
                        <span class="inline-flex items-center mt-1 text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                            Aladhan Live Engine Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @vite(['resources/js/dashboardscript.js'])
</body>
</html>