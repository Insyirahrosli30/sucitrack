<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack — Cycle Logs</title>
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
                <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                <span class="font-bold text-base tracking-tight text-stone-800">SuciTrack</span>
            </div>
            <div class="flex items-center space-x-6 text-sm font-medium text-stone-500">
                <a href="#" class="text-stone-800 border-b-2 border-stone-800 px-1 py-5">History</a>
                <a href="#" class="hover:text-stone-800 transition px-1 py-5">Dashboard</a>
                <a href="#" class="hover:text-stone-800 transition px-1 py-5">Qada' List</a>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-10">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-stone-100 pb-6 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-stone-900 tracking-tight">Period Records</h1>
                <p class="text-sm text-stone-400 mt-1">Track and manage your history logs and ritual purity cycles.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('menstrual_records.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-stone-900 hover:bg-stone-800 rounded-lg shadow-sm transition duration-150 ease-in-out">
                    + Log New Cycle
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-sm text-emerald-800 flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white border border-stone-100 rounded-xl shadow-sm overflow-hidden">
            @if($menstrual_records->isEmpty())
                <div class="p-12 text-center">
                    <p class="text-sm text-stone-400">No menstrual records logged yet. Begin by tracking your first cycle entry.</p>
                </div>
          @else {{-- This is your line 57 --}}
                <div class="overflow-x-auto"> {{-- This is your line 58 --}}
                    <table class="w-full text-left border-collapse"> {{-- This is your line 59 --}}
                        <thead>
                            <tr class="bg-stone-50 border-b border-stone-100">
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-stone-500">Start Date & Time</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-stone-500">End Date & Time</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-stone-500">Duration</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-stone-500 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach($menstrual_records as $m)
                                <tr class="hover:bg-stone-50/50 transition duration-150">
                                    <td class="px-6 py-4 text-sm font-medium text-stone-700 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($m->start_datetime)->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-stone-600 whitespace-nowrap">
                                        @if($m->end_datetime)
                                            {{ \Carbon\Carbon::parse($m->end_datetime)->format('d M Y, h:i A') }}
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100">
                                                Active Ongoing
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-stone-500 whitespace-nowrap">
                                        @if($m->duration_days)
                                            <span class="font-medium text-stone-700">{{ $m->duration_days }}</span> days
                                        @else
                                            <span class="text-stone-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('menstrual_records.edit', $m->id) }}" class="text-sm font-medium text-stone-600 hover:text-stone-900 transition">
                                                Edit
                                            </a>
                                            <span class="text-stone-200">|</span>
                                            <form action="{{ route('menstrual_records.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this cycle log?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-rose-600 hover:text-rose-800 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif {{-- CRITICAL: Closes the @if from line 53 --}}
        </div>
    </main>

    </body>
</html>