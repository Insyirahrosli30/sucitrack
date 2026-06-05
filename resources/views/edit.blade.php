
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack — Log Period End</title>
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
            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('menstrual_records.index') }}" class="text-stone-800 px-1 py-5 transition">History & Records</a>
                <a href="{{ route('dashboard') }}" class="text-stone-400 hover:text-stone-800 transition px-1 py-5">Dashboard</a>
                <a href="{{ route('qada.index') }}" class="text-stone-400 hover:text-stone-800 transition px-1 py-5">Qada' List</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Form Area -->
    <main class="max-w-xl mx-auto px-6 py-12">
        <div class="bg-white border border-stone-100 rounded-2xl p-8 shadow-sm">
            
            <div class="mb-6">
                <h1 class="text-xl font-bold text-stone-900 tracking-tight">Log Period End (Purified)</h1>
                <p class="text-xs text-stone-400 mt-1">Update your ongoing record to mark the precise time of purification.</p>
            </div>

            <!-- Form Submitting to the Update Route -->
            <form action="{{ route('menstrual_records.update', $record->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Display the logged Start Date for context -->
                <div>
                    <label class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-2">Period Started On</label>
                    <div class="h-11 w-full rounded-xl border border-stone-100 bg-stone-50 px-4 flex items-center text-sm text-stone-600 font-medium">
                        {{ \Carbon\Carbon::parse($record->start_datetime)->format('F d, Y — h:i A') }}
                    </div>
                </div>

                <!-- Input for End Date -->
                <div>
                    <label for="end_datetime" class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2">End Date & Time (Purification)</label>
                    <input type="datetime-local" 
                           id="end_datetime" 
                           name="end_datetime" 
                           value="{{ old('end_datetime', $record->end_datetime ? \Carbon\Carbon::parse($record->end_datetime)->format('Y-m-d\TH:i') : '') }}"
                           class="h-11 w-full rounded-xl border border-stone-200 bg-white px-4 text-sm outline-none focus:border-stone-800 transition"
                           required>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-2">
                    <a href="{{ route('dashboard') }}" class="h-11 px-5 rounded-xl text-xs font-semibold text-stone-600 bg-stone-50 hover:bg-stone-100 transition flex items-center justify-center">
                        Cancel
                    </a>
                    <button type="submit" class="h-11 px-5 rounded-xl text-xs font-semibold text-white bg-stone-900 hover:bg-stone-800 transition shadow-sm">
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>