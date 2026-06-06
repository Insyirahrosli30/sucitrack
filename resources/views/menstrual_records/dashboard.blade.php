<x-app-layout>

<!-- HEADER -->
<div class="border-b border-pink-200 pb-6 mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Assalamualaikum</h1>
    <p class="text-sm text-gray-500 mt-1">
        Overview of your cycle, prayer times and Qada' tracking.
    </p>
</div>

<!-- MAIN LAYOUT -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT SIDE -->
    <div class="lg:col-span-2 space-y-6">

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl border border-pink-100">
                <p class="text-xs text-gray-400 uppercase">Days of Purity</p>
                <div class="text-3xl font-bold mt-2 text-gray-400">-</div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-pink-100">
                <p class="text-xs text-gray-400 uppercase">Cycle Status</p>
                <div class="text-lg font-bold mt-2 text-gray-400">Not connected</div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-pink-100">
                <p class="text-xs text-gray-400 uppercase">Pending Qada'</p>
                <div class="text-3xl font-bold text-pink-600 mt-2">-</div>
            </div>

        </div>

        <!-- TRACK CYCLE -->
        <div class="bg-white border border-pink-100 rounded-xl p-6">

            <h2 class="text-lg font-semibold">Track Cycle</h2>

            <div class="flex gap-4 mt-6">

                <a href="{{ route('menstrual_records.create') }}"
                   class="flex-1 text-center py-4 rounded-xl bg-pink-50 text-pink-700 border border-pink-200 hover:bg-pink-100 transition">
                    Log Period Start
                </a>

                <a href="{{ route('menstrual_records.index') }}"
                   class="flex-1 text-center py-4 rounded-xl bg-pink-600 text-white hover:bg-pink-700 transition">
                    Log Period End
                </a>

            </div>

        </div>

    </div>

    <!-- RIGHT SIDE (PRAYER) -->
    <div class="space-y-4">

        <div class="bg-white border border-pink-100 rounded-xl p-6">

            <h2 class="text-lg font-semibold mb-4">Prayer Times</h2>

            <div class="space-y-3">

                @foreach($prayer as $key => $time)

                    <div class="flex justify-between items-center p-3 rounded-xl border
                        {{ $nextPrayer === $key
                            ? 'bg-pink-200 border-pink-400'
                            : 'bg-pink-50 border-pink-100' }}">

                        <div>
                            <p class="text-xs text-gray-500">
                                {{ $labels[$key] }}
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $time }}
                            </p>
                        </div>

                        @if($nextPrayer === $key)
                            <span class="text-xs font-bold text-pink-700">
                                NEXT
                            </span>
                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

</x-app-layout>