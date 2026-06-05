<x-app-layout>
    <div class="max-w-md mx-auto px-6 py-10">
        <div class="border-b border-stone-100 pb-6 mb-8">
            <h1 class="text-2xl font-bold text-stone-900 tracking-tight">Modify Cycle Entry</h1>
            <p class="text-sm text-stone-400 mt-1">Adjust your tracked timestamps below.</p>
        </div>

        <form action="{{ route('menstrual_records.update', $menstrualRecord->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="start_datetime" class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2">Start Timestamp</label>
                <input type="datetime-local" name="start_datetime" id="start_datetime" 
                       value="{{ \Carbon\Carbon::parse($menstrualRecord->start_datetime)->format('Y-m-d\TH:i') }}"
                       class="w-full px-4 py-3 bg-white border border-stone-200 rounded-xl text-sm focus:outline-none focus:border-stone-400 font-mono text-stone-700" required>
            </div>

            <div>
                <label for="end_datetime" class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2">End Timestamp (Optional)</label>
                <input type="datetime-local" name="end_datetime" id="end_datetime" 
                       value="{{ $menstrualRecord->end_datetime ? \Carbon\Carbon::parse($menstrualRecord->end_datetime)->format('Y-m-d\TH:i') : '' }}"
                       class="w-full px-4 py-3 bg-white border border-stone-200 rounded-xl text-sm focus:outline-none focus:border-stone-400 font-mono text-stone-700">
                <p class="text-[11px] text-stone-400 mt-1.5">Leave blank if this flow is actively ongoing.</p>
            </div>

            <div class="pt-4 flex items-center space-x-3">
                <button type="submit" class="flex-1 px-4 py-3 bg-stone-900 text-white rounded-xl text-sm font-medium hover:bg-stone-800 transition shadow-sm">
                    Save Modifications
                </button>
                <a href="{{ route('menstrual_records.index') }}" class="px-4 py-3 bg-stone-100 text-stone-600 rounded-xl text-sm font-medium hover:bg-stone-200 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>