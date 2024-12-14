<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use App\Models\Reservation;
use App\Services\CacheTickets;
use Illuminate\Support\Facades\Auth;
use App\Jobs\DeleteReservationEmail;


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
      $user = $reservation->user;

      // store reservation details before removing
      $reservationDetails = [
         'id' => $reservation->id,
         'reservation_date' => $reservation->reservation_date
      ];

      // sending details reservation for delete to owner
      DeleteReservationEmail::dispatch($user, $reservationDetails);

      // delete reservation
      $reservation->delete();

      //update tickets and cache after removing reservation
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
