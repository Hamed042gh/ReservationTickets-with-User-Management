<link href="{{ asset('css/output.css') }}" rel="stylesheet">
@if ($payments->isEmpty())
    <div class="flex justify-center items-center h-screen">
        <div class="text-center">
            <a href="{{ route('dashboard') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 inline-block mb-4">
                Dashboard
            </a>
            <div class="text-gray-600 text-lg font-semibold">
                No payments available at the moment.
            </div>
        </div>
    </div>
@else
    <div class="mb-4">
        <div class="mb-4 flex space-x-4">
            <a href="{{ route('tickets') }}"
                class="bg-orange-300 text-black px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-orange-400 hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Create New Reservation
            </a>
            <a href="{{ route('dashboard') }}"
                class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-blue-700 hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Dashboard
            </a>
            <a href="{{ route('reservations') }}"
                class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-green-700 hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                My Reservations
            </a>
        </div>

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
                    <td class="border border-gray-300 px-4 py-2 bg-red-100">{{ $payment->reservation->ticket->origin }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2 bg-pink-100">
                        {{ $payment->reservation->ticket->destination }}</td>
                    <td class="border border-gray-300 px-4 py-2 bg-teal-100">
                        {{ match (\App\Enums\PaymentStatus::from($payment->status)) {
                            \App\Enums\PaymentStatus::SUCCESS_CONFIRMED => 'Paid',
                            \App\Enums\PaymentStatus::PENDING => 'Processing',
                            \App\Enums\PaymentStatus::INTERNAL_ERROR => 'Internal Error',
                            \App\Enums\PaymentStatus::CANCELED_BY_USER => 'Canceled',
                            default => 'Unknown Status',
                        } }}
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endif
