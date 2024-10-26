<!DOCTYPE html>
<html lang="en">
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
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket Reservation</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles

    </head>

    <body class="bg-gray-100">

     
        <livewire:ticket-reservation />

        @livewireScripts

    </body>

</html>
