<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- LOGIN STATUS CARD -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- WELCOME SECTION -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    Welcome back, {{ Auth::user()->name }}
                </h2>

                <p class="text-sm text-gray-500">
                    Track cycle data and prayer schedule in one place
                </p>
            </div>

            <!-- QUICK INFO CARDS -->
            <div class="grid grid-cols-2 gap-4 mb-6">

                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold text-green-600">Active</p>
                </div>

                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="font-semibold">
                        {{ now()->format('d M Y') }}
                    </p>
                </div>

            </div>

            <!-- SUCITRACK OVERVIEW -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-3">
                        SuciTrack Overview
                    </h3>

                    <p class="text-sm text-gray-600 mb-4">
                        This section displays menstrual tracking data and prayer time integration.
                    </p>

                </div>
            </div>

            <!-- PRAYER CARD -->
            <div class="bg-white rounded-lg shadow p-5">

                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-gray-800">
                        Prayer Times Today
                    </h4>

                    <span class="text-xs text-gray-500">
                        Rawang, Selangor
                    </span>
                </div>

                @if(isset($prayer))

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">

                        <div class="flex justify-between border-b pb-2">
                            <span>Subuh</span>
                            <span class="font-medium">{{ $prayer['fajr'] ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span>Zohor</span>
                            <span class="font-medium">{{ $prayer['dhuhr'] ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span>Asar</span>
                            <span class="font-medium">{{ $prayer['asr'] ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span>Maghrib</span>
                            <span class="font-medium">{{ $prayer['maghrib'] ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Isyak</span>
                            <span class="font-medium">{{ $prayer['isha'] ?? '-' }}</span>
                        </div>

                    </div>

                @else
                    <p class="text-red-500 text-sm">
                        Prayer data unavailable. Please refresh later.
                    </p>
                @endif

            </div>

            <!-- REMINDER CARD -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg shadow p-5 mt-6">

                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xl">🔔</span>

                    <h4 class="font-semibold text-yellow-800">
                        Reminder Notification
                    </h4>
                </div>

                <p class="text-sm text-yellow-700">
                    Prayer reminders and qada' prayer notifications will be displayed here.
                </p>

                <div class="mt-3 text-sm text-gray-600">
                    Example:
                    <br>
                    • Maghrib prayer is approaching.
                    <br>
                    • Check your menstrual cycle status before prayer.
                </div>

            </div>

        </div>
    </div>
</x-app-layout>