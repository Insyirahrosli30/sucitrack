<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-50 via-white to-purple-50 px-4 py-10">

        <div class="w-full max-w-md bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl border border-white/50 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-300 via-pink-200 to-purple-300 p-8 text-center">

                <div class="text-5xl mb-2">
                    🌙
                </div>

                <h1
                    style="
                    font-family:'Cinzel', serif;
                    font-size:50px;
                    letter-spacing:2px;
                    font-weight:700;
                    color:white;
                    text-shadow:
                        -1px -1px 0 #ec4899,
                         1px -1px 0 #ec4899,
                        -1px  1px 0 #a855f7,
                         1px  1px 0 #a855f7,
                         0px  0px 12px rgba(236,72,153,.35);
                    ">
                    SUCITRACK
                </h1>

                <p class="text-white/90 mt-3 text-sm tracking-wide">
                    Menstrual & Prayer Tracking System
                </p>

            </div>

            <div class="p-8">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your full name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <!-- Email -->
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="example@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <!-- Password -->
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Create password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <!-- Register Button -->
                    <button
                        type="submit"
                        class="w-full mt-6 bg-gradient-to-r from-pink-300 to-purple-300 hover:from-pink-400 hover:to-purple-400 text-gray-800 font-bold text-lg py-3 rounded-xl shadow-md transition duration-300">
                        Create Account
                    </button>

                    <!-- Login -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-500">
                            Already have an account?

                            <a href="{{ route('login') }}"
                               class="font-semibold text-pink-500 hover:text-purple-500">
                                Login
                            </a>
                        </p>
                    </div>

                </form>

            </div>

        </div>

    </div>
</x-guest-layout>