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
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
        }

        .logo-font{
            font-family:'Cinzel',serif;
        }

        .gradient-text{
            background:linear-gradient(
                90deg,
                #ff7ad9,
                #c084fc
            );
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <nav class="border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">

            
        <div class="flex items-center gap-2">
            <span class="text-yellow-400 text-xl relative top-[0px]">
                ☾
            </span>

            <span class="font-[Cinzel] text-xl leading-none font-bold bg-gradient-to-r from-pink-300 to-purple-400 bg-clip-text text-transparent">
                SUCITRACK
            </span>
        </div>

        <div class="flex items-center gap-3">
    
            <a href="{{ route('login') }}"
                class="px-6 py-3 rounded-full border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition flex items-center justify-center">
                    Login
            </a>

            <a href="{{ route('register') }}"
                class="px-6 py-3 rounded-full bg-gradient-to-r from-pink-400 to-purple-400 text-white font-medium shadow-sm hover:opacity-90 transition flex items-center justify-center">
                    Register
            </a>

        </div>

        </div>

    </nav>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-6 py-24 text-center">

        <div class="mb-2 text-yellow-400 text-5xl">
        ☾
        </div>

        <h1 class="logo-font text-6xl md:text-7xl font-bold gradient-text mb-6">
            SUCITRACK
        </h1>

        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            A menstrual and prayer tracking platform designed to help Muslim women monitor their cycle, manage prayer obligations and maintain spiritual wellbeing with confidence.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">

            <a href="{{ route('register') }}"
               class="px-8 py-4 rounded-xl bg-gradient-to-r from-pink-400 to-purple-400 text-white font-semibold shadow-lg hover:scale-105 transition">
                Get Started
            </a>

            <a href="{{ route('login') }}"
               class="px-8 py-4 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                Already Have an Account?
            </a>

        </div>

    </section>

    <!-- Features -->
    <section class="bg-gray-50 py-20">

        <div class="max-w-6xl mx-auto px-6">

            <h2 class="text-4xl font-bold text-center mb-14">
                Everything You Need
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="text-3xl mb-4">🩸</div>
                    <h3 class="font-semibold text-lg mb-2">
                        Menstrual Tracking
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Record and monitor menstrual cycles accurately.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="text-3xl mb-4">🕌</div>
                    <h3 class="font-semibold text-lg mb-2">
                        Prayer Monitoring
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Track prayer obligations based on cycle status.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="text-3xl mb-4">📋</div>
                    <h3 class="font-semibold text-lg mb-2">
                        Qada' Management
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Keep track of pending and completed qada' prayers.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="text-3xl mb-4">🔔</div>
                    <h3 class="font-semibold text-lg mb-2">
                        Smart Reminders
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Receive notifications and important reminders.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section class="py-24">

        <div class="max-w-4xl mx-auto text-center px-6">

            <h2 class="text-4xl font-bold mb-6">
                Start Your Journey With SuciTrack
            </h2>

            <p class="text-gray-500 mb-8">
                Register today and simplify menstrual and prayer tracking in one place.
            </p>

            <a href="{{ route('register') }}"
               class="inline-block px-8 py-4 rounded-xl bg-gradient-to-r from-pink-400 to-purple-400 text-white font-semibold shadow-lg">
                Create Account
            </a>

        </div>

    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-100 py-8 text-center text-gray-500 text-sm">
        © 2026 SuciTrack. All Rights Reserved.
    </footer>

</body>
</html>