<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [

        'user_id',
        'ticket_id',
        'payment_id',
        'status',
        'reservation_date'

    ];
}
