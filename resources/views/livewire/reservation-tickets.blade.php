<div>

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
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 text-white p-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- 10 min warning-->
                    <div class="bg-yellow-500 text-black p-4 rounded mb-6">
                        <p class="text-lg font-semibold">You have only 10 minutes to complete your reservation!</p>
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
