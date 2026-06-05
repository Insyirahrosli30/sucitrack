<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack Calendar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Plus+Jakarta+Sans:wght=400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FBFBFA !important;
        }
        /* Custom day box rules that inject cleanly via the JS loop */
        .calendar-day-box {
            background-color: #ffffff !important;
            border: 1px solid #e7e5e4 !important;
            border-radius: 0.75rem !important;
            min-height: 90px !important;
            padding: 0.6rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }
        .period-day {
            background-color: #fecdd3 !important; /* Rose tint color */
            border-color: #fda4af !important;
        }
        .other-month {
            background-color: #f5f5f4 !important;
            opacity: 0.5;
        }
    </style>
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
                <a href="{{ route('calendar') }}" class="text-stone-800 border-b-2 border-stone-800 px-1 py-5 transition">Calendar</a>
                <a href="{{ route('menstrual_records.index') }}" class="text-stone-400 hover:text-stone-800 transition px-1 py-5">History & Records</a>
                <a href="{{ route('dashboard') }}" class="text-stone-400 hover:text-stone-800 transition px-1 py-5">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-stone-400 hover:text-rose-600 font-medium text-sm transition pl-2">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <script>
        window.menstrualRecords = {!! $records->toJson() !!};
    </script>

    <main class="max-w-5xl mx-auto px-6 py-10 bg-[#FBFBFA]">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 id="calendar-month-year" class="text-xl font-bold text-stone-900 tracking-tight">Loading Month...</h2>
                <p class="text-xs text-stone-400 mt-0.5">Interactive view of your tracked states.</p>
            </div>
            <div class="flex space-x-2">
                <button id="prev-month-btn" class="px-3 py-2 bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs font-medium rounded-xl transition">Previous</button>
                <button id="next-month-btn" class="px-3 py-2 bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs font-medium rounded-xl transition">Next Month</button>
            </div>
        </div>

        <div class="text-center text-xs font-semibold text-stone-400 tracking-wider uppercase mb-4" 
             style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important; gap: 1rem !important;">
            <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
        </div>

        <div id="calendar-days-grid" 
             style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important; gap: 1rem !important;">
            </div>

    </main>

    @vite(['resources/js/calendarscript.js'])
</body>
</html>