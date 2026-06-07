<x-app-layout>

<style>
.gradient-text{
    background: linear-gradient(90deg,#ec4899,#a855f7);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* Start button turns into outline when END is hovered */
.start-outline{
    background:#fdf2f8 !important;
    color:#be185d !important;
    border:1px solid #fbcfe8 !important;
    background-image:none !important;
}

/* scale effect consistency */
.btn-scale:hover{
    transform: scale(1.02);
}
</style>

<div class="flex justify-center pt-12">

    <div class="w-full max-w-7xl space-y-8">

        <!-- HEADER -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

            <h1 class="text-2xl font-bold gradient-text">
                Period Records
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Track and manage your history logs and purity cycles.
            </p>

            @php
                $activeCycle = \App\Models\MenstrualRecord::where('user_id', auth()->id())
                    ->whereNull('end_datetime')
                    ->latest()
                    ->first();
            @endphp

            <div class="mt-5 flex gap-4">

                <!-- START -->
                <a href="{{ route('menstrual_records.create') }}"
                    id="startBtn"
                    class="btn-scale flex-1 text-center px-5 py-3 rounded-2xl
                           bg-gradient-to-r from-pink-400 to-purple-400
                           text-white font-medium transition duration-300">

                    Period Start

                </a>

                <!-- END / STATUS -->
                @if($activeCycle)

                    <a href="{{ route('menstrual_records.end') }}"
                       id="endBtn"
                       class="btn-scale flex-1 text-center px-5 py-3 rounded-2xl
                              bg-pink-50 text-pink-700 border border-pink-200
                              font-medium transition duration-300
                              hover:bg-gradient-to-r
                              hover:from-pink-400
                              hover:to-purple-400
                              hover:text-white
                              hover:border-transparent">

                        Period End

                    </a>

                @else

                    <div class="flex-1 text-center px-5 py-3 rounded-2xl bg-gray-100 text-gray-400 border border-gray-200 font-medium">
                        No Active Cycle
                    </div>

                @endif

            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl shadow-sm overflow-hidden">

            <!-- HEADER -->
            <div class="grid grid-cols-5 gap-4 p-4 bg-pink-50/60 text-xs font-semibold text-gray-600 text-center">
                <div>No.</div>
                <div>Start Date & Time</div>
                <div>End Date & Time</div>
                <div>Status</div>
                <div>Actions</div>
            </div>

            @forelse($menstrual_records as $index => $record)

                <div class="grid grid-cols-5 gap-4 p-5 border-t border-pink-100 text-sm items-center text-center hover:bg-pink-50/40 transition">

                    <div class="font-medium text-gray-700">
                        {{ $index + 1 }}
                    </div>

                    <div class="text-gray-700">
                        {{ \Carbon\Carbon::parse($record->start_datetime)->format('d M Y, h:i A') }}
                    </div>

                    <div class="text-gray-700">
                        @if($record->end_datetime)
                            {{ \Carbon\Carbon::parse($record->end_datetime)->format('d M Y, h:i A') }}
                        @else
                            <span class="text-pink-500 font-medium">Ongoing</span>
                        @endif
                    </div>

                    <div>
                        @if($record->end_datetime)
                            <span class="inline-flex px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700 border border-gray-200">
                                Completed
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 rounded-full text-xs bg-green-50 text-green-700 border border-green-200">
                                Active
                            </span>
                        @endif
                    </div>

                    <div class="flex justify-center gap-2">

                        <a href="{{ route('menstrual_records.edit', $record->id) }}"
                           class="px-3 py-1 text-xs rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('menstrual_records.destroy', $record->id) }}"
                              onsubmit="return confirm('Delete this record?')">

                            @csrf
                            @method('DELETE')

                            <button class="px-3 py-1 text-xs rounded-xl bg-red-100 text-red-700 hover:bg-red-200">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="p-12 text-center text-gray-400 text-sm">
                    No period records yet
                </div>

            @endforelse

        </div>

    </div>

</div>

<script>
const startBtn = document.getElementById('startBtn');
const endBtn = document.getElementById('endBtn');

if (startBtn && endBtn) {

    endBtn.addEventListener('mouseenter', () => {
        startBtn.classList.add('start-outline');
    });

    endBtn.addEventListener('mouseleave', () => {
        startBtn.classList.remove('start-outline');
    });

    startBtn.addEventListener('mouseenter', () => {
        startBtn.classList.remove('start-outline');
    });

}
</script>

</x-app-layout>