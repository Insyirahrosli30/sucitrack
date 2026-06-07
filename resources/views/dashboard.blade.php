<x-app-layout>

<style>
.gradient-text{
    background: linear-gradient(90deg,#ec4899,#a855f7);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}
</style>

<div class="flex justify-center pt-12">
    <div class="w-full max-w-7xl">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            <!-- LEFT SIDE -->
            <div class="lg:col-span-2 space-y-6">

                <!-- HEADER -->
                <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

                    <h1 class="text-2xl font-bold gradient-text">
                        Assalamualaikum, Sister 🩷
                    </h1>

                    <p class="text-gray-500 mt-3 text-sm">
                        Overview of your cycle, prayer times and Qada' tracking.
                    </p>

                </div>

                <!-- STATS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-sm text-center">
                        <p class="text-xs text-gray-400 uppercase">Days of Purity</p>
                        <div class="text-3xl font-bold mt-2 text-gray-700">
                            {{ $daysOfPurity ?? '-' }}
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-sm text-center">
                        <p class="text-xs text-gray-400 uppercase">Cycle Status</p>
                        <div class="text-lg font-bold mt-2 text-gray-700">
                            {{ $isClean ? 'Clean' : 'Active' }}
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-sm text-center">
                        <p class="text-xs text-gray-400 uppercase">Pending Qada'</p>
                        <div class="text-3xl font-bold mt-2 text-pink-600">
                            {{ $pendingQadaCount ?? 0 }}
                        </div>
                    </div>

                </div>

                <!-- TRACK SECTION -->
                <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        Track your cycle here
                    </h2>

                    <p class="text-sm text-gray-500 mt-2">
                        View, manage and update your menstrual records.
                    </p>

                    <a href="{{ route('menstrual_records.index') }}"
                       class="mt-5 inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                              bg-gradient-to-r from-pink-400 to-purple-400
                              text-white font-medium
                              hover:scale-[1.02]
                              transition duration-300">

                        <span>Record Cycle</span>
                        <span>🌸</span>

                    </a>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-10 h-fit">

                <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

                    <h2 class="text-lg font-semibold mb-4 text-gray-800">
                        Prayer Times
                    </h2>

                    <div class="space-y-3">

                        @foreach($prayer as $key => $time)

                            <div class="flex justify-between items-center p-3 rounded-2xl border text-sm
                                {{ $nextPrayer === $key
                                    ? 'bg-gradient-to-r from-pink-200 to-purple-200 border-pink-300'
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

    </div>
</div>

</x-app-layout>