<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<form action="/payment/request" method="POST" class="max-w-md mx-auto mt-10 p-6 bg-white shadow-lg rounded-md">
    @csrf

    <div class="text-center mb-6">
        <img src="{{ asset('images/ticket.png') }}" alt="Shaparak Logo" class="mx-auto w-32 h-auto">
    </div>

    <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $ticket->id }}">
    <input type="hidden" name="amount" id="amount" value="{{$ticket->amount }}">
    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
    <input type="hidden" name="reservation_id" id="reservation_id" value="{{ $reservation_id}}">


    <div class="mb-4">

        <p class="text-lg font-semibold text-gray-700"><strong>Payer Identity:</strong> {{ auth()->user()->email }}</p>
        <p class="text-lg font-semibold text-gray-700"><strong>Payer Name:</strong> {{ auth()->user()->name }}</p>
        <p class="text-lg font-semibold text-gray-700"><strong>Description:</strong> Payment for online purchase</p>
        <p class="text-lg font-semibold text-gray-700"><strong>Amount:</strong>{{$ticket->amount }} ریال</p>
    </div>

    <input type="hidden" name="payerIdentity" value="{{ auth()->user()->email }}">
    <input type="hidden" name="payerName" value="{{ auth()->user()->name }}">
    <input type="hidden" name="description" value="Payment for online purchase">

    <button type="submit"
        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
        Proceed to Payment
    </button>

    <div class="mt-6 flex justify-center items-center space-x-4">
        <script src="https://zibal.ir/trust/scripts/1.js" type="text/javascript"></script>
        <img src="{{ asset('images/shaparak.png') }}" alt="Shaparak Logo" class="w-16 h-auto">
    </div>

</form>
