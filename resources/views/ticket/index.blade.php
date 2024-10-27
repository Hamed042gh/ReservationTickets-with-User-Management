<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket Reservation</title>
        @livewireStyles
        <link href="{{ asset('css/output.css') }}" rel="stylesheet">
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
        <script>
            Livewire.on('showError', message => {
                alert(message);
            });
        </script>
    </body>

</html>
