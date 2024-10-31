<link href="{{ asset('css/output.css') }}" rel="stylesheet">
<div class="mb-4">
    <a href="/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Dashboard</a>
    <a href="/reservations" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">My Reservations</a>
    <a href="/tickets" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-700">Create New Reservation</a>
</div>
<table class="min-w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2 text-left bg-blue-200">Name</th>
            <th class="border border-gray-300 px-4 py-2 text-left bg-green-200">Tracking Number</th>
            <th class="border border-gray-300 px-4 py-2 text-left bg-yellow-200">Payment Date</th>
            <th class="border border-gray-300 px-4 py-2 text-left bg-purple-200">Amount</th>
            <th class="border border-gray-300 px-4 py-2 text-left bg-red-200">From</th>
            <th class="border border-gray-300 px-4 py-2 text-left bg-pink-200">To</th>
            <th class="border border-gray-300 px-4 py-2 text-left bg-teal-200"> Payment Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td class="border border-gray-300 px-4 py-2 bg-blue-100">{{ $payment->payer_name }}</td>
                <td class="border border-gray-300 px-4 py-2 bg-green-100">{{ $payment->track_id }}</td>
                <td class="border border-gray-300 px-4 py-2 bg-yellow-100">
                    {{ $payment->created_at->format('Y-m-d H:i:s') }}</td>
                <td class="border border-gray-300 px-4 py-2 bg-purple-100">{{ $payment->amount }} Rials</td>
                <td class="border border-gray-300 px-4 py-2 bg-red-100">{{ $payment->reservation->ticket->origin }}</td>
                <td class="border border-gray-300 px-4 py-2 bg-pink-100">
                    {{ $payment->reservation->ticket->destination }}</td>
                <td class="border border-gray-300 px-4 py-2 bg-teal-100">
                    @switch($payment->status)
                        @case(\App\Enums\PaymentStatus::SUCCESS_CONFIRMED->value)
                            Paid
                        @break

                        @case(\App\Enums\PaymentStatus::PENDING->value)
                            Processing
                        @break

                        @case(\App\Enums\PaymentStatus::INTERNAL_ERROR->value)
                            Internal Error
                        @break

                        @case(\App\Enums\PaymentStatus::CANCELED_BY_USER->value)
                            Canceled
                        @break

                        @default
                            Unknown Status
                    @endswitch
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
