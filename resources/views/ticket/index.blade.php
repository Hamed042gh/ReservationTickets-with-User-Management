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
    <form class="mb-4">
      <input 
        type="text" 
        class="border p-2 w-full md:w-1/2 rounded-lg focus:outline-none" 
        placeholder="Search for tickets (Origin, Destination, Date)">
      <button class="mt-2 bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-500">Search</button>
    </form>

    <!-- Ticket List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <!-- Ticket Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-bold">From: Earth</h2>
        <p class="text-sm">To: Mars</p>
        <p class="text-sm">Departure: 2024-12-25 10:00 AM</p>
        <p class="text-sm">Available Seats: 15</p>
        <p class="text-sm font-bold">Price: $150</p>
        <button class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 w-full">Reserve</button>
      </div>
      <!-- Ticket Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-bold">From: Earth</h2>
        <p class="text-sm">To: Mars</p>
        <p class="text-sm">Departure: 2024-12-25 10:00 AM</p>
        <p class="text-sm">Available Seats: 15</p>
        <p class="text-sm font-bold">Price: $150</p>
        <button class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 w-full">Reserve</button>
      </div>
      <!-- Ticket Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-bold">From: Earth</h2>
        <p class="text-sm">To: Mars</p>
        <p class="text-sm">Departure: 2024-12-25 10:00 AM</p>
        <p class="text-sm">Available Seats: 15</p>
        <p class="text-sm font-bold">Price: $150</p>
        <button class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 w-full">Reserve</button>
      </div>
      <!-- Ticket Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-bold">From: Earth</h2>
        <p class="text-sm">To: Mars</p>
        <p class="text-sm">Departure: 2024-12-25 10:00 AM</p>
        <p class="text-sm">Available Seats: 15</p>
        <p class="text-sm font-bold">Price: $150</p>
        <button class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 w-full">Reserve</button>
      </div>
      <!-- Ticket Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-bold">From: Earth</h2>
        <p class="text-sm">To: Mars</p>
        <p class="text-sm">Departure: 2024-12-25 10:00 AM</p>
        <p class="text-sm">Available Seats: 15</p>
        <p class="text-sm font-bold">Price: $150</p>
        <button class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 w-full">Reserve</button>
      </div>
      <!-- Ticket Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-bold">From: Earth</h2>
        <p class="text-sm">To: Mars</p>
        <p class="text-sm">Departure: 2024-12-25 10:00 AM</p>
        <p class="text-sm">Available Seats: 15</p>
        <p class="text-sm font-bold">Price: $150</p>
        <button class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 w-full">Reserve</button>
      </div>
      <!-- Repeat this block for other tickets -->
    </div>
  </section>

</body>
</html>
