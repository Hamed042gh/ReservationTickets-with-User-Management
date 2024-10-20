<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket Reservation</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100">

        <!-- Navbar -->
        <header class="bg-blue-600 p-4 text-white text-center">
            <h1 class="text-xl font-bold">Ticket Reservation</h1>
        </header>

        <!-- Search Section -->
        <section class="container mx-auto p-6">
            <form class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
                <input type="text"
                    class="border p-2 w-full md:w-1/2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Search for tickets (Origin, Destination, Date)">
                <button
                    class="mt-2 md:mt-0 md:ml-2 bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-500 transition duration-200">Search</button>
            </form>

            <!-- Ticket List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Ticket Card -->
                @foreach ($tickets as $ticket)
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                        <h2 class="text-lg font-bold">From: {{ $ticket->origin }}</h2>
                        <p class="text-sm font-bold">To: {{ $ticket->destination }}</p>
                        <p class="text-sm font-bold">Departure: {{ $ticket->departure_date }}</p>
                        <p class="text-sm font-bold text-red-500">Available Seats: {{ $ticket->available_count }}</p>
                        <p class="text-sm font-bold">Price: ${{ $ticket->amount }}</p>
                        <button
                            class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 transition duration-200 w-full">Reserve</button>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $tickets->links('pagination::tailwind') }}
            </div>
        </section>

    </body>

</html>
