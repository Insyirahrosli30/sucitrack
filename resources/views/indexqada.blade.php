

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack — Qada' List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FBFBFA] text-[#1F2937] antialiased min-h-screen">

    <nav class="bg-white border-b border-stone-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            
            <div class="flex items-center space-x-2">
                <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
                <span class="font-bold text-base tracking-tight text-stone-800">SuciTrack</span>
            </div>
            
            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('menstrual_records.index') }}" 
                   class="text-stone-400 hover:text-stone-800 transition px-1 py-5">
                   History & Records
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="text-stone-400 hover:text-stone-800 transition px-1 py-5">
                   Dashboard
                </a>
                <a href="{{ route('qada.index') }}" 
                   class="text-stone-800 border-b-2 border-stone-800 px-1 py-5 transition">
                   Qada' List
                </a>
            </div>

        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-10">
        
        <div class="border-b border-stone-100 pb-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-stone-900 tracking-tight">Missed Prayers (Qada' List)</h1>
                <p class="text-sm text-stone-400 mt-1">Keep accurate accountability of prayers to be made up following your cycles.</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-stone-600 bg-white border border-stone-200 hover:bg-stone-50 transition shadow-sm">
                    ← Back to Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white border border-stone-100 rounded-xl p-8 text-center shadow-sm max-w-xl mx-auto my-12">
            <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                🕌
            </div>
            <h3 class="text-base font-semibold text-stone-800">Prayer Records Initializing</h3>
            <p class="text-xs text-stone-400 mt-2 max-w-sm mx-auto leading-relaxed">
                Your missed prayer  are successfully connected
            </p>
        </div>

    </main>

</body>
</html>