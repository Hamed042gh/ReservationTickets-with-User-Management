<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Reservation Confirmation</title>
    </head>

    <body>
        <h1>Reservation Confirmation</h1>
        <p>Dear:<strong>{{ $reservation->user->name }}</strong>,</p>
        <p>Thank you for making a reservation with us. Here are the details of your reservation:</p>

        <h2>Reservation Details:</h2>
        <p><strong>Ticket:</strong> {{ $reservation->user->name }}</p>
        <p><strong>Amount:</strong> {{ $reservation->payment->amount }} T</p>
        <p><strong>Reservation Status:</strong> Reserved successfully!</p>
        <p><strong>Reservation Date:</strong> {{ $reservation->created_at->format('Y-m-d H:i:s') }}</p>
        <p>If you would like to cancel your reservation, please click on the link below:</p>
        <p><a href="http://localhost/reservations" style="color: #cc0000; font-weight: bold;">Cancel Reservation</a></p>
        <p>If you have any questions, feel free to contact us at Email:<strong>blearn704@gmail.com</strong></p>
    </body>

</html>
