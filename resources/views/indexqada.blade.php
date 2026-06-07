<x-app-layout>

<div class="flex justify-center pt-12">

    <div class="w-full max-w-7xl space-y-8">

        <!-- HEADER -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

            <h1 class="text-2xl font-bold gradient-text">
                Missed Prayers (Qada')
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Track your missed prayers
            </p>

        </div>

        <!-- SUMMARY -->
        <div class="grid grid-cols-3 gap-6">

            <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase">Pending</p>
                <div class="text-3xl font-bold text-pink-600 mt-2">
                    {{ $pendingQadaCount ?? 0 }}
                </div>
            </div>

            <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase">Completed</p>
                <div class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $completedQadaCount ?? 0 }}
                </div>
            </div>

            <div class="bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-sm">
                <p class="text-xs text-gray-400 uppercase">Status</p>
                <div class="text-lg font-semibold text-gray-700 mt-2">
                    Tracking Active
                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white/60 backdrop-blur-md border border-pink-100 rounded-3xl p-6 shadow-sm">

            <table class="w-full text-sm">

                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Date</th>
                        <th class="py-2">Prayer</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Notes</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($qadaLogs as $qada)

                    <tr class="border-b">
                        <td class="py-2">{{ $qada->qada_date }}</td>
                        <td class="py-2">{{ $qada->prayer_type }}</td>
                        <td class="py-2">
                            {{ $qada->is_completed ? 'Completed' : 'Pending' }}
                        </td>
                        <td class="py-2">{{ $qada->notes ?? '-' }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-400">
                            No Qada records yet
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</x-app-layout>