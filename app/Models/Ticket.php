<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $casts = [
        'amount' => 'integer',
    ];
    protected $fillable = [

        'origin',
        'destination',
        'departure_time',
        'departure_date',
        'amount',
        'available_count'

    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
