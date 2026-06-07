<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SuciTrack') }}</title>

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
            background:linear-gradient(90deg,#ec4899,#a855f7);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-pink-200">

    @include('layouts.navigation')

    <main class="max-w-7xl mx-auto px-6 py-8">
        {{ $slot }}
    </main>

</body>
</html>