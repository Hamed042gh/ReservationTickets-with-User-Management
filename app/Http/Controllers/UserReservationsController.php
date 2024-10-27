<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserReservationsController  extends Controller
{

   public function showReservations()
   {
      return view('userReservations.reservations');
   }


   public function showFinance()
   {
      return view('userReservations.finance');
   }
}
