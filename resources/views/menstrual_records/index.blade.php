<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="flex items-center justify-between border-b border-stone-100 pb-6 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-stone-900 tracking-tight">Cycle History Data</h1>
                <p class="text-sm text-stone-400 mt-1">Review your raw tracked timelines below.</p>
            </div>
            <a href="{{ route('menstrual_records.create') }}" class="px-4 py-2.5 bg-stone-900 text-white rounded-xl text-sm font-medium hover:bg-stone-800 transition shadow-sm">
                + New Entry
            </a>
        </div>

        @if($records->isEmpty())
            <div class="text-center py-16 bg-white border border-stone-100 rounded-2xl shadow-sm">
                <p class="text-sm text-stone-400">No records found. Enter a timeline to populate metrics.</p>
            </div>
        @else
            <div class="bg-white border border-stone-100 rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-100 text-xs font-semibold text-stone-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Start Date</th>
                            <th class="px-6 py-4">End Date</th>
                            <th class="px-6 py-4 text-right">Operations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-sm text-stone-700">
                       @foreach($records as $record)
    <tr class="hover:bg-stone-50/50 transition">
        <td class="px-6 py-4 font-mono text-stone-600">
            {{ \Carbon\Carbon::parse($record->start_datetime)->format('d M Y, h:i A') }}
        </td>
        <td class="px-6 py-4 font-mono text-stone-500">
            @if($record->end_datetime)
                {{ \Carbon\Carbon::parse($record->end_datetime)->format('d M Y, h:i A') }}
            @else
                <form action="{{ route('routes/web.php' ? 'menstrual_records.log_end' : 'menstrual_records.log_end', $record->id) }}" method="POST" class="flex items-center space-x-2">
                    @csrf
                    @method('PUT')
                    <input type="datetime-local" name="end_datetime" required
                           class="px-2 py-1 bg-stone-50 border border-stone-200 rounded-lg text-xs font-mono text-stone-700 focus:outline-none focus:border-stone-400">
                    <button type="submit" class="px-2 py-1 bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium rounded-lg transition shadow-sm">
                        Save End
                    </button>
                </form>
            @endif
        </td>
        <td class="px-6 py-4 text-right space-x-3">
            <a href="{{ route('menstrual_records.edit', $record->id) }}" class="text-xs text-stone-500 hover:text-stone-900 font-medium">Edit</a>
            <form action="{{ route('menstrual_records.destroy', $record->id) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-rose-400 hover:text-rose-600 font-medium" onclick="return confirm('Purge record entry?')">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>