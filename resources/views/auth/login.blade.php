<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SuciTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Plus+Jakarta+Sans:wght=400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#FBFBFA] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-sm bg-white border border-stone-100 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center space-x-2 mb-6 justify-center">
            <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
            <span class="font-bold text-lg tracking-tight text-stone-800">SuciTrack</span>
        </div>
        
        <h2 class="text-xl font-bold text-stone-900 tracking-tight text-center">Welcome back</h2>
        <p class="text-xs text-stone-400 text-center mt-1 mb-6">Enter your credentials to access your account.</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-1.5">Email Address</label>
                <input type="email" name="email" required autofocus class="w-full px-3 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-sm focus:outline-none focus:border-stone-400 transition" />
            </div>
            <div>
                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-1.5">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-sm focus:outline-none focus:border-stone-400 transition" />
            </div>
            <button type="submit" class="w-full py-3 bg-stone-900 text-white rounded-xl text-sm font-medium hover:bg-stone-800 transition shadow-sm mt-2">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>