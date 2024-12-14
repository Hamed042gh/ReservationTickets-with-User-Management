<?php

namespace App\Jobs;

use App\Mail\DeleteReservationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteReservationEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $reservationDetails;
    public function __construct($user, $reservationDetails)
    {
        $this->user = $user;
        $this->reservationDetails = $reservationDetails;
    }

    /** 
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new DeleteReservationMail($this->user, $this->reservationDetails));
    }
}
