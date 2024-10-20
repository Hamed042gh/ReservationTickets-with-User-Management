<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [

        'origin',
        'destination',
        'departure_time',
        'departure_date',
        'amount',
        'available_count'

    ];
  
}
