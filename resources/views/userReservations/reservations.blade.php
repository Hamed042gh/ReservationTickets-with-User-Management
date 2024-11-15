<link href="{{ asset('css/output.css') }}" rel="stylesheet">
<div class="flex justify-end mb-6">
    <a href="{{ route('dashboard') }}"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
        Dashboard
    </a>

</div>
<div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    @if ($Reservations->isEmpty())
        <p>No reservation</p>
    @else
        @foreach ($Reservations as $reservation)
            <div class="bg-white rounded-lg shadow-lg p-6 transition-transform duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Reservations Details</h3>
                <div class="text-gray-600">
                    <p class="mb-2">
                        <span class="font-bold">Origin:</span> {{ $reservation->ticket->origin }}
                    </p>
                    <p class="mb-2">
                        <span class="font-bold">Destination:</span> {{ $reservation->ticket->destination }}
                    </p>
                    <p class="mb-2">
                        <span class="font-bold">Departure Date:</span>
                        {{ $reservation->reservation_date }}
                    </p>
                    <p class="mb-2">
                        <span class="font-bold">Amount:</span>
                        {{ $reservation->ticket->amount }} Rail
                    </p>
                    <p class="mb-2 text-blue-600" style="color: blue !important;">
                        @if ($reservation->status == 1)
                            <span class="font-bold">Status:</span>
                            <p class="mb-2 text-blue-600" style="color: green !important;">Reserved</p>
                        @elseif ($reservation->status == -1)
                            <span class="font-bold">Status:</span>
                            <p class="mb-2 text-blue-600" style="color: red !important;">Canceled</p>
                        @elseif ($reservation->status == 0)
                            <span class="font-bold">Status:</span>
                            <p class="mb-2 text-yellow-600" style="color: rgb(0, 0, 0) !important;">Pending
                                <a class="w-full bg-yellow-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded transition duration-100"
                                    href="{{ route('purchase', $reservation->ticket->id) }}">Reserve again</a>
                            </p>
                        @endif

                    </p>
                    <p>
                        <a href=""> edit</a>
                        <form action="{{ route('deleteReservation', $reservation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </p>
                </div>
            </div>
 @endforeach
        @endif
        {{ $Reservations->links() }}
</div>
