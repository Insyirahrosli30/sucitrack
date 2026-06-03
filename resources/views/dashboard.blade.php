<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />

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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

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

                    <p class="text-sm text-gray-600">
                        This section displays menstrual tracking data and prayer time integration.
                    </p>

                </div>
            </div>

            <!-- PRAYER CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <!-- Header -->
                <div class="mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">
                        Prayer Times
                    </h4>
                    <p class="text-sm text-gray-500">
                        Rawang, Selangor
                    </p>
                </div>

                @if(!empty($prayer))

                    <!-- Next prayer badge -->
                    <div class="mb-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                            bg-pink-50 text-pink-600 border border-pink-100">
                            Next: {{ $labels[$nextPrayer] }}
                        </span>
                    </div>

                    <!-- List -->
                    <div class="space-y-2">

                        <div class="flex justify-between items-center p-3 rounded-xl
                            {{ $nextPrayer === 'Fajr' ? 'bg-pink-50 border border-pink-100' : 'bg-gray-50' }}">
                            <span class="text-gray-700">{{ $labels['Fajr'] }}</span>
                            <span class="font-medium text-gray-900">{{ $prayer['Fajr'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 rounded-xl
                            {{ $nextPrayer === 'Dhuhr' ? 'bg-pink-50 border border-pink-100' : 'bg-gray-50' }}">
                            <span class="text-gray-700">{{ $labels['Dhuhr'] }}</span>
                            <span class="font-medium text-gray-900">{{ $prayer['Dhuhr'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 rounded-xl
                            {{ $nextPrayer === 'Asr' ? 'bg-pink-50 border border-pink-100' : 'bg-gray-50' }}">
                            <span class="text-gray-700">{{ $labels['Asr'] }}</span>
                            <span class="font-medium text-gray-900">{{ $prayer['Asr'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 rounded-xl
                            {{ $nextPrayer === 'Maghrib' ? 'bg-pink-50 border border-pink-100' : 'bg-gray-50' }}">
                            <span class="text-gray-700">{{ $labels['Maghrib'] }}</span>
                            <span class="font-medium text-gray-900">{{ $prayer['Maghrib'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 rounded-xl
                            {{ $nextPrayer === 'Isha' ? 'bg-pink-50 border border-pink-100' : 'bg-gray-50' }}">
                            <span class="text-gray-700">{{ $labels['Isha'] }}</span>
                            <span class="font-medium text-gray-900">{{ $prayer['Isha'] }}</span>
                        </div>

                    </div>

                @else

                    <div class="text-sm text-gray-500">
                        Loading prayer data. Please refresh later.
                    </div>

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