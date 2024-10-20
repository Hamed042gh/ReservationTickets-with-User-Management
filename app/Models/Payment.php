<?php

namespace App\Models;

use App\Models\User;
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
        'track_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
