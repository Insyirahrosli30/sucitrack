<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SuciTrack</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-white flex items-center justify-center">

    <div class="w-full max-w-md bg-white/70 backdrop-blur-md shadow-lg rounded-2xl p-8 border border-pink-100">

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="text-3xl">☾</div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome back</h1>
            <p class="text-gray-500 text-sm">Login to continue your SuciTrack journey</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>

            <div>
                <label class="text-sm text-gray-600">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>

            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-400 to-purple-400 text-white font-semibold hover:opacity-90 transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            No account yet?
            <a href="{{ route('register') }}" class="text-pink-500 font-medium hover:underline">
                Register
            </a>
        </p>

    </div>

</body>
</html>