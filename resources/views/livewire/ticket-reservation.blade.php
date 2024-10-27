<div>
    <div>
        <!-- نمایش پیام موفقیت یا خطا -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- سایر محتویات صفحه... -->
    </div>

    <!-- Search Section -->
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
            {{-- another botton --}}
            <a href="/dashboard"
                class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 transition duration-200 w-full md:w-auto mr-1 text-center">
                Dashboard
            </a>
            <a href="/reservations"
                class="bg-yellow-600 text-white p-2 rounded-lg hover:bg-yellow-500 transition duration-200 w-full md:w-auto text-center">
                Reservations
            </a>
        </div>
    </form>

    <!-- Ticket List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($tickets as $ticket)
            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                <h2 class="text-lg font-bold">From: {{ $ticket->origin }}</h2>
                <p class="text-sm font-bold">To: {{ $ticket->destination }}</p>
                <p class="text-sm font-bold">Departure: {{ $ticket->departure_date }}</p>
                <p class="text-sm font-bold text-red-500">Available Seats: {{ $ticket->available_count }}</p>
                <p class="text-sm font-bold">Price:{{ intval($ticket->amount) }} ریال</p>

                <button type="button"
                    class="mt-2 bg-green-600 text-white p-2 rounded-lg hover:bg-green-500 transition duration-200 w-full"
                    wire:click="handleMessageSubmission({{ $ticket->id }})">Reserve</button>
            </div>
        @endforeach

        @if ($previewReservation)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Reservation Preview</h3>
                            <div class="mt-2">
                                <p>From: {{ $selectedTicket->origin }}</p>
                                <p>To: {{ $selectedTicket->destination }}</p>
                                <p>Departure Date: {{ $reservationData['reservation_date'] }}</p>
                                <p>Available Seats: {{ $selectedTicket->available_count }}</p>
                                <p>Price:{{ intval($selectedTicket->amount) }} ریال</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" wire:click="confirmReservation"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-500 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Confirm
                            </button>
                            <button type="button" wire:click="resetPreview"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    {{ $tickets->links() }}
</div>
