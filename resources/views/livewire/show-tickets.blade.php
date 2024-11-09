<div>

    @if ($noTicketsMessage)
        <div class="bg-yellow-500 text-black p-4 rounded">
            {{ $noTicketsMessage }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($tickets as $ticket)
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200" data-ticket-id="{{ $ticket->id }}">
            <h2 class="text-lg font-bold">From: {{ $ticket->origin }}</h2>
            <p class="text-sm font-bold">To: {{ $ticket->destination }}</p>
            <p class="text-sm font-bold">Departure: {{ $ticket->departure_date }}</p>
            <p class="text-sm font-bold text-red-500">
                Available Seats: <span class="available-count">{{ $ticket->available_count }}</span>
            </p>
            <p class="text-sm font-bold">Price: {{ intval($ticket->amount) }} ریال</p>
    
            <button wire:click="$dispatchTo('reservation-tickets','reserve', { ticketId: {{ $ticket->id }} })"
                class="bg-blue-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                Reserve
            </button>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination links -->

    <div class="flex justify-center mt-6">
        {{ $tickets->links('pagination::tailwind') }}
    </div>

</div>
