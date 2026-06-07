<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuciTrack</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .logo-font {
            font-family: 'Cinzel', serif;
        }

        .gradient-text {
            background: linear-gradient(90deg, #ec4899, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-pink-100 via-purple-100 to-pink-200 text-gray-800">

    <main class="min-h-screen flex flex-col justify-center">

        <section class="max-w-4xl mx-auto px-6 pt-16 pb-12 text-center">

            <div class="text-6xl mb-5 text-pink-500">
                ☾
            </div>

            <h1 class="logo-font text-6xl md:text-7xl font-bold gradient-text mb-6">
                SUCITRACK
            </h1>

            <p class="text-gray-600 text-base leading-relaxed max-w-2xl mx-auto mb-10">
                A menstrual and prayer tracking platform designed to help Muslim women monitor their cycle,
                manage prayer obligations and maintain spiritual wellbeing with confidence.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">

                <a href="{{ route('register') }}"
                   class="px-8 py-4 rounded-xl bg-gradient-to-r from-pink-400 to-purple-400 text-white font-semibold shadow-lg hover:scale-105 transition">
                    Get Started
                </a>

                <a href="{{ route('login') }}"
                   class="px-8 py-4 rounded-xl bg-white/70 backdrop-blur-md border border-pink-200 text-pink-700 font-semibold hover:bg-white transition">
                    Already Have an Account?
                </a>

            </div>

        </section>

        <section class="max-w-6xl mx-auto px-6 pb-10">

            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-8">
                Everything You Need
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                <div class="bg-white/60 backdrop-blur-md p-6 rounded-2xl border border-pink-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition text-center">

                    <div class="text-3xl mb-3">
                        🩸
                    </div>

                    <h3 class="font-semibold text-lg mb-2">
                        Menstrual Tracking
                    </h3>

                    <p class="text-sm text-gray-500">
                        Record and monitor menstrual cycles accurately.
                    </p>

                </div>

                <div class="bg-white/60 backdrop-blur-md p-6 rounded-2xl border border-pink-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition text-center">

                    <div class="text-3xl mb-3">
                        🕌
                    </div>

                    <h3 class="font-semibold text-lg mb-2">
                        Prayer Monitoring
                    </h3>

                    <p class="text-sm text-gray-500">
                        Track prayer obligations based on cycle status.
                    </p>

                </div>

                <div class="bg-white/60 backdrop-blur-md p-6 rounded-2xl border border-pink-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition text-center">

                    <div class="text-3xl mb-3">
                        📋
                    </div>

                    <h3 class="font-semibold text-lg mb-2">
                        Qada' Management
                    </h3>

                    <p class="text-sm text-gray-500">
                        Manage pending and completed qada' prayers.
                    </p>

                </div>

                <div class="bg-white/60 backdrop-blur-md p-6 rounded-2xl border border-pink-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition text-center">

                    <div class="text-3xl mb-3">
                        🔔
                    </div>

                    <h3 class="font-semibold text-lg mb-2">
                        Smart Reminders
                    </h3>

                    <p class="text-sm text-gray-500">
                        Receive timely notifications and important reminders.
                    </p>

                </div>

            </div>

        </section>

    </main>

</body>
</html>