<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-[#ff5e88] to-[#ff9966] min-h-screen flex flex-col items-center justify-center">

    <h1>Calendar</h1>

    <div class="calendar">
        <header>
            <h3></h3>
            <nav>
                <button id="prev">Prev</button>
                <button id="next">Next</button>
            </nav>
        </header>

        <section>
            <ul class="days">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
            </ul>

            <ul class="dates"></ul>
        </section>
    </div>

</body>
</html>