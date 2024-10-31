<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationsController  extends Controller
{

   public function showReservations()
   {

      $Reservations = Reservation::with('ticket')
         ->where('user_id', Auth::id())
         ->where('status', 1)
         ->paginate(3);

      return view('userReservations.reservations', compact('Reservations'));
   }


   public function showFinance()
   {
      return view('userReservations.finance');
   }
}
