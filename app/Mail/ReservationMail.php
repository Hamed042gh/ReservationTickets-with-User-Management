<?php

namespace App\Mail;


use App\Models\User;
use App\Models\Reservation;
use Illuminate\Mail\Mailable;

class ReservationMail extends Mailable
{
    public $user;
    public $reservation;

    public function __construct(User $user, Reservation $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Reservation Confirmation')
            ->view('emails.reservation');
    }
}
