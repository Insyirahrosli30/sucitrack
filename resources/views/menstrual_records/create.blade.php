<x-app-layout>

<div class="max-w-xl mx-auto">

    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500">
        ← Back to Dashboard
    </a>

    <div class="bg-white border border-pink-100 rounded-xl p-8 mt-6">

        <form method="POST" action="{{ route('menstrual_records.store') }}">
            @csrf

            <input type="datetime-local"
                   name="start_datetime"
                   class="w-full border border-pink-200 rounded-xl p-3">

            <button class="mt-6 w-full bg-pink-600 text-white py-3 rounded-xl">
                Save Record Entry
            </button>

        </form>

    </div>

</div>

</x-app-layout>