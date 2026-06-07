<x-app-layout>

<style>
.gradient-text{
    background: linear-gradient(90deg,#ec4899,#a855f7);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}
</style>

<div class="flex justify-center pt-12">

    <div class="w-full max-w-2xl space-y-8">

        <!-- HEADER -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

            <h1 class="text-2xl font-bold gradient-text">
                End Cycle
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Set the end date and time for this cycle
            </p>

        </div>

        <!-- DETAILS CARD -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm space-y-4">

            <div>
                <p class="text-xs text-gray-400 uppercase">Start Date & Time</p>
                <p class="text-gray-700 font-medium">
                    {{ \Carbon\Carbon::parse($record->start_datetime)->format('d M Y, h:i A') }}
                </p>
            </div>

        </div>

        <!-- FORM CARD -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

            <form method="POST" action="{{ route('menstrual_records.update', $record->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- END DATETIME -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        End Date & Time
                    </label>

                    <input type="datetime-local"
                           name="end_datetime"
                           required
                           class="w-full rounded-2xl border border-pink-100 p-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3">

                    <a href="{{ route('menstrual_records.index') }}"
                       class="px-5 py-2 rounded-2xl border border-pink-200 text-gray-600 hover:bg-pink-50 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-6 py-2 rounded-2xl bg-gradient-to-r from-pink-400 to-purple-400 text-white font-medium hover:scale-[1.02] transition">
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>