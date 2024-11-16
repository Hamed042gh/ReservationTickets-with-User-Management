<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Mail\Mailable;


class DeleteReservationMail extends Mailable
{
    public $user;
    public $reservationDetails;

    public function __construct($user, $reservationDetails)
    {
        $this->user = $user;
        $this->reservationDetails = $reservationDetails;
    }

    public function build()
    {
        return $this->subject('Reservation Deleted!')
            ->view('emails.deleteReservation');
    }
}
