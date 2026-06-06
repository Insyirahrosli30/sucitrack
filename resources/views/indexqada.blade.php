<x-app-layout>

<!-- HEADER -->
<div class="border-b border-pink-200 pb-6 mb-8">
    <h1 class="text-2xl font-bold">Missed Prayers (Qada')</h1>
    <p class="text-sm text-gray-500 mt-1">
        Track your missed prayers
    </p>
</div>

<!-- PRAYER STATUS OVERVIEW (RESTORED SECTION) -->
<div class="bg-white border border-pink-100 rounded-xl p-6 mb-6">

    <h2 class="text-lg font-semibold mb-4">Prayer Status Overview</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">

        <div>
            <p class="text-xs text-gray-400">Subuh</p>
            <p class="font-semibold text-gray-700">Pending</p>
        </div>

        <div>
            <p class="text-xs text-gray-400">Zohor</p>
            <p class="font-semibold text-gray-700">Pending</p>
        </div>

        <div>
            <p class="text-xs text-gray-400">Asar</p>
            <p class="font-semibold text-gray-700">Pending</p>
        </div>

        <div>
            <p class="text-xs text-gray-400">Maghrib</p>
            <p class="font-semibold text-gray-700">Pending</p>
        </div>

        <div>
            <p class="text-xs text-gray-400">Isya'</p>
            <p class="font-semibold text-gray-700">Pending</p>
        </div>

    </div>
</div>

<!-- SUMMARY CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <div class="bg-white p-6 rounded-xl border border-pink-100">
        <p class="text-xs text-gray-400 uppercase">Pending</p>
        <div class="text-3xl font-bold text-pink-600 mt-2">
            {{ $pendingQadaCount ?? 0 }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-pink-100">
        <p class="text-xs text-gray-400 uppercase">Completed</p>
        <div class="text-3xl font-bold mt-2">
            {{ $completedQadaCount ?? 0 }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-pink-100">
        <p class="text-xs text-gray-400 uppercase">Status</p>
        <div class="text-lg font-semibold mt-2 text-gray-700">
            Tracking Active
        </div>
    </div>

</div>

<!-- ORIGINAL UI BLOCK (YOU PROVIDED - KEPT AS IS) -->
<div class="bg-white border border-pink-100 rounded-xl p-8 text-center">

    <div class="text-3xl">🕌</div>

    <h3 class="font-semibold mt-4">
        Qada System Active
    </h3>

    <p class="text-sm text-gray-400 mt-2">
        Your records are connected
    </p>

</div>

</x-app-layout>