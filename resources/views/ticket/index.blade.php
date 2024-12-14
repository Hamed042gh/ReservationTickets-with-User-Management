<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket Reservation</title>
        @livewireStyles
        @vite('resources/css/app.css')
        <link href="{{ asset('css/output.css') }}" rel="stylesheet">
        @guest
            <a href="{{ route('login') }}"
                class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-md transition duration-200 hover:bg-blue-700">
                Log in
            </a>
            <a href="{{ route('register') }}"
                class="px-6 py-3 bg-green-500 text-white font-semibold rounded-md transition duration-200 hover:bg-green-700">
                Register
            </a>
        @endguest
    </head>

    <body class="bg-gray-100">

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

        <livewire:search-tickets />
        <livewire:show-tickets />
        <livewire:reservation-tickets />

        @livewireScripts
        @vite('resources/js/app.js')
        <script>
            Livewire.on('showError', message => {
                alert(message);
            });
        </script>
    </body>

</html>
