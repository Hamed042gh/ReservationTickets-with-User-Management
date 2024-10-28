<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Reservation;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function showTickets()
    {
        return view('ticket.index');
    }

    public function purchase(Ticket $ticket)
    {
      
        $ticket->amount = intval($ticket->amount);
        $reservation_id = Reservation::where('ticket_id', $ticket->id)->value('id');

        return view('ticket.purchase', ['ticket' => $ticket, 'reservation_id' => $reservation_id]);
    }
}
