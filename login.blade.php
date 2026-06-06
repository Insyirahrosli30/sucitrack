<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-50 via-white to-purple-50 px-4">

        <div class="w-full max-w-md bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl border border-white/50 overflow-hidden">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-pink-200 via-pink-300 to-purple-300 p-8 text-center">

                <div class="flex flex-col items-center justify-center">

                    <div class="text-5xl mb-3">
                        🌙
                    </div>

                    <h1
                        class="font-bold text-center leading-none"
                        style="
                            font-family:'Cinzel', serif;
                            font-size:50px;
                            letter-spacing:2px;
                            color:white;
                            text-shadow:
                                1px 0 #ec4899,
                               -1px 0 #ec4899,
                                0 1px #a855f7,
                                0 -1px #a855f7,
                                0 0 10px rgba(168,85,247,.35);
                        ">
                        SUCITRACK
                    </h1>

                    <p class="text-white/90 mt-4 text-sm tracking-wider text-center">
                        Menstrual & Prayer Tracking System
                    </p>

                </div>

            </div>

            <!-- BODY -->
            <div class="p-8">

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="example@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition">
                    </div>

                    <!-- PASSWORD -->
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition">
                    </div>

                    <!-- REMEMBER -->
                    <div class="flex items-center justify-between mt-5">

                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-pink-500">

                            <span class="ml-2 text-sm text-gray-600">
                                Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm font-medium text-pink-500 hover:text-purple-500 transition">
                                Forgot Password?
                            </a>
                        @endif

                    </div>

                    <!-- LOGIN BUTTON -->
                    <button
                        type="submit"
                        class="w-full mt-6 bg-gradient-to-r from-pink-300 to-purple-300 hover:from-pink-400 hover:to-purple-400 text-gray-800 font-bold text-lg py-3 rounded-xl shadow-md transition duration-300">
                        Login
                    </button>

                    <!-- REGISTER -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-500">
                            Don't have an account?

                            <a href="{{ route('register') }}"
                               class="font-semibold text-pink-500 hover:text-purple-500 transition">
                                Register
                            </a>
                        </p>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>