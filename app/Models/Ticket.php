<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [

        'origin',
        'destination',
        'departure_time',
        'departure_date',
        'amount',
        'available_count'

    ];
  
}
