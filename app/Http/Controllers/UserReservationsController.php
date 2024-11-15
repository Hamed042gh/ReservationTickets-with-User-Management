<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use App\Models\Reservation;
use App\Services\CacheTickets;
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

   public function deleteReservation($id, CacheTickets $cacheTickets)
   {
      $reservation = Reservation::where('id', $id)
      ->where('user_id', Auth::id())
      ->firstOrFail();   
      $ticket = $reservation->ticket;
      $reservation->delete();
      if ($ticket) {
         $ticket->increment('available_count');
         $cacheTickets->clearCache();
      }

      return redirect()->route('dashboard')->with('success', 'Reservation deleted successfully.');
   }


   public function showFinance()
   {
      $payments = Payment::with('reservation')
         ->where('user_id', Auth::id())
         ->get();
      return view('userReservations.finance', compact('payments'));
   }
}
