<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FBFBFA] text-[#1F2937] antialiased min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-stone-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            
            
            <div class="flex items-center space-x-2">
                <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
                <span class="font-bold text-base tracking-tight text-stone-800">SuciTrack</span>
            </div>
            
           <!-- Navigation Links Wrapper -->
<div class="flex items-center space-x-6 text-sm font-medium">
    <a href="{{ route('menstrual_records.index') }}" 
       class="text-stone-400 hover:text-stone-800 transition px-1 py-5">
       History & Records
    </a>
    <a href="{{ route('dashboard') }}" 
       class="text-stone-800 border-b-2 border-stone-800 px-1 py-5 transition">
       Dashboard
    </a>
    <a href="{{ route('qada.index') }}" 
       class="text-stone-400 hover:text-stone-800 transition px-1 py-5">
       Qada' List
    </a>
</div>

        </div>
    </nav>

    <!-- Main Content Matching the Proportional Spacing -->
    <main class="max-w-5xl mx-auto px-6 py-10">
        
        <!-- Welcome Hero Header -->
        <div class="border-b border-stone-100 pb-6 mb-8">
            <h1 class="text-2xl font-bold text-stone-900 tracking-tight">Assalamualaikum, Sister</h1>
            <p class="text-sm text-stone-400 mt-1">Here is the overview of your current ritual purity and tracking status.</p>
        </div>

        <!-- Metric Indicator Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Purity Card -->
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

            <!-- Cycle Status Card -->
            <div class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Current Cycle Status</p>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-xl font-bold text-stone-800">
                        {{ $isClean ? 'Suci (Pure)' : 'Haid (Active)' }}
                    </span>
                </div>
                <p class="text-xs text-stone-400 mt-3 font-medium">
                    {{ $activeRecord ? 'Started on: ' . \Carbon\Carbon::parse($activeRecord->start_datetime)->format('d M, h:i A') : 'System monitoring active' }}
                </p>
            </div>

            <!-- Qada' Card -->
            <div class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Unresolved Qada' Prayers</p>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-3xl font-bold {{ $pendingQadaCount > 0 ? 'text-rose-500' : 'text-stone-800' }}">
                        {{ $pendingQadaCount }}
                    </span>
                    <span class="text-sm text-stone-400 font-medium">Prayers Owed</span>
                </div>
                <p class="text-xs text-stone-400 mt-2 font-medium">Requires clearing before completion</p>
            </div>
        </div>

        <!-- Operations Panel Layout Split -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-stone-800">Track Current Status</h2>
                    <p class="text-sm text-stone-400 mt-1 mb-6">Instantly register boundaries to automate local calculations.</p>
                    
                <div class="flex flex-col sm:flex-row gap-4">
    <!-- Log Period Start Button -->
    
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('menstrual_records.create') }}" class="flex-1 inline-flex items-center justify-center px-5 py-4 border border-stone-200 rounded-xl text-sm font-medium text-stone-700 bg-white hover:bg-stone-50 transition duration-150">
        <span class="w-2 h-2 rounded-full bg-rose-400 mr-3 animate-pulse"></span>
        Log Period Start
        </a>

     <a href="{{ $activeRecord ? route('menstrual_records.edit', $activeRecord->id) : route('menstrual_records.index') }}" class="flex-1 inline-flex items-center justify-center px-5 py-4 rounded-xl text-sm font-medium text-white bg-stone-900 hover:bg-stone-800 transition duration-150 shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        Log Period End (Purified)
    </a>
</div>
   
        </div>
    </div>
</div>

            <!-- Configuration Info Box Sidebar -->
            <div class="space-y-6">
                <div class="bg-white border border-stone-100 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-stone-800 mb-4">Tracking Configuration</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-stone-400 uppercase tracking-wider">Current Zone Selection</label>
                            <p class="text-sm font-medium text-stone-700 mt-1 flex items-center">
                                <svg class="w-4 h-4 text-stone-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                SGR01 — Gombak / Shah Alam
                            </p>
                        </div>
                        <div class="pt-2 border-t border-stone-50">
                            <label class="block text-xs font-medium text-stone-400 uppercase tracking-wider">API Sync Node</label>
                            <span class="inline-flex items-center mt-1 text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                JAKIM e-Solat Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>