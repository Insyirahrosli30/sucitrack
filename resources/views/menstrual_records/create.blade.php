<x-app-layout>
    <div class="max-w-md mx-auto px-6 py-12">
        <div class="bg-white border border-stone-100 rounded-2xl p-8 shadow-sm">
            <h1 class="text-xl font-bold text-stone-900 tracking-tight">Log new timeline entry</h1>
            <p class="text-xs text-stone-400 mt-1 mb-6">Enter bounds to update calculation rules.</p>

            <form method="POST" action="{{ route('menstrual_records.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-1.5">Start Datetime</label>
                    <input type="datetime-local" name="start_datetime" required class="w-full px-3 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-sm focus:outline-none focus:border-stone-400 transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-1.5">End Datetime (Optional)</label>
                    <input type="datetime-local" name="end_datetime" class="w-full px-3 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-sm focus:outline-none focus:border-stone-400 transition" />
                </div>
                
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('dashboard') }}" class="w-1/2 py-3 border border-stone-200 text-center rounded-xl text-sm font-medium text-stone-600 hover:bg-stone-50 transition">Cancel</a>
                    <button type="submit" class="w-1/2 py-3 bg-stone-900 text-white rounded-xl text-sm font-medium hover:bg-stone-800 transition shadow-sm">Save Boundary</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>