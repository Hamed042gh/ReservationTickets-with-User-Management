<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Reservation;
use App\Mail\ReservationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReservationEmail implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $reservation;


    public function __construct(User $user, Reservation $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;
    }

 
    public function handle()
    {
 
        Mail::to($this->user->email)->send(new ReservationMail($this->user, $this->reservation));
    }
}
