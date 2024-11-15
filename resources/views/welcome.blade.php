<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TicketReservation</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-black">
        <div class="text-center px-6 lg:max-w-7xl w-full max-w-md">
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">Welcome to Ticket Reservation</h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Your journey starts here</p>
            </header>

            <!-- Main Content (Buttons) -->
            <div class="mt-6 flex justify-center space-x-6">
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-md transition duration-200 hover:bg-blue-700">
                    Log in
                </a>
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-green-500 text-white font-semibold rounded-md transition duration-200 hover:bg-green-700">
                    Register
                </a>
            </div>
        </div>
    </div>
</body>

</html>
