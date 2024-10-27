<x-app-layout>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket Information
        </h2>
    </x-slot>

    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-4">About Our Tickets</h3>
        <p class="mb-2">We offer a variety of tickets for different events. Whether you're looking for concerts, sports, or theatre, we have something for everyone!</p>
        <p class="mb-2">All our tickets are available for immediate reservation or purchase. Make sure to check the availability before proceeding!</p>
        <p class="mb-2">For any assistance, feel free to contact our support team.</p>
        <p class="mb-4">Stay tuned for upcoming events and special offers!</p>
    </div>

    <div class="mt-6 text-center text-gray-600">
        <p>This design is presented solely for coding practice by Hamed Ghasemi.</p>
    </div>
</x-app-layout>
