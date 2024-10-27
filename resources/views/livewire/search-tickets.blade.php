<div>
    <form class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between" wire:submit.prevent="search">
        <input type="text" wire:model="searchByOrigin"
            class="border p-2 w-full md:w-1/4 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 md:mr-2 mb-1 md:mb-0"
            placeholder="Search by Origin">

        <input type="text" wire:model="searchByDestination"
            class="border p-2 w-full md:w-1/4 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 mb-1 md:mb-0"
            placeholder="Search by Destination">

        <input type="date" wire:model="searchByReservation_date"
            class="border p-2 w-full md:w-1/4 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 mb-1 md:mb-0"
            placeholder="Select a Date">

        <div class="flex md:w-auto mt-2 md:mt-0">
            <button
                class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-500 transition duration-200 w-full md:w-auto mr-1">
                Search
            </button>
            <a class="bg-green-600 text-white p-2 rounded-lg hover:bg-blue-500 transition duration-200 w-full md:w-auto mr-1" href="/dashboard">Dashboard</a>
        </div>
</div>
