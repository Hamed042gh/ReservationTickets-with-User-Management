<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Reservation Cancellation</title>
    </head>

    <body>
        <h1>Reservation Cancellation</h1>
        <p>Dear: <strong>{{ $user->name }}</strong>,</p>
        <p>We regret to inform you that your reservation has been cancelled. Below are the details of your cancelled
            reservation:</p>

        <h2>Reservation Details:</h2>
        <p><strong>Reservation Status:</strong> Cancelled</p>
        <p><strong>Cancellation Date:</strong>{{ $reservationDetails['reservation_date'] }} </p>

        <p>If you have any questions, feel free to contact us at Email: <strong>blearn704@gmail.com</strong></p>
    </body>

</html>
