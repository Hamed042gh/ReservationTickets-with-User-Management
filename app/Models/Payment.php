<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable =
    [
        'amount',
        'user_id',
        'status',
        'payer_name',
        'payer_identity',
        'order_id',
        'track_id',
        'reservation_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
