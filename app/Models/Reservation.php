<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
  use HasFactory;
    protected $fillable = [

        'user_id',
        'ticket_id',
        'payment_id',
        'status',
        'reservation_date'

    ];

    public function payment()
    {
      return $this->hasOne(Payment::class);  
    }

    public function user()
    {
      return $this->belongsTo(User::class);  
    }

    public function ticket()
    {
      return $this->belongsTo(Ticket::class);  
    }


}
