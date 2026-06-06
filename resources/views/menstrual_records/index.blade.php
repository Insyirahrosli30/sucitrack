<x-app-layout>

<!-- HEADER SECTION -->
<div class="border-b border-pink-200 pb-6 mb-8">

    <h1 class="text-2xl font-bold">Period Records</h1>

    <p class="text-sm text-gray-500 mt-1">
        Track and manage your history logs and purity cycles.
    </p>

    <!-- ADD BUTTON -->
    <div class="mt-4">
        <a href="{{ route('menstrual_records.create') }}"
           class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-xl text-sm hover:bg-pink-700 transition">
            + Add New Cycle
        </a>
    </div>

</div>

<!-- TABLE SECTION -->
<div class="bg-white border border-pink-100 rounded-xl overflow-hidden">

    <div class="grid grid-cols-3 gap-4 p-4 bg-pink-50 text-xs font-semibold text-gray-600">
        <div>No.</div>
        <div>Start Date & Time</div>
        <div>Status Map</div>
    </div>

    @forelse($records ?? [] as $index => $record)

        <div class="grid grid-cols-3 gap-4 p-4 border-t border-pink-100 text-sm items-center">

            <div class="text-gray-700">
                {{ $index + 1 }}
            </div>

            <div class="text-gray-700">
                {{ \Carbon\Carbon::parse($record->start_datetime)->format('d M Y, h:i A') }}
            </div>

            <div>
                <span class="px-3 py-1 rounded-full text-xs bg-pink-50 text-pink-700 border border-pink-100">
                    Active
                </span>
            </div>

        </div>

    @empty

        <div class="p-8 text-center text-gray-400 text-sm">
            No period records yet
        </div>

    @endforelse

</div>

</x-app-layout>