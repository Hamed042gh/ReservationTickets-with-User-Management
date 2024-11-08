<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Reservation;
use App\Services\LockTicket;



class TicketController extends Controller
{
    public function showTickets()
    {
        return view('ticket.index');
    }

    public function purchase(Ticket $ticket, LockTicket $lockTicket)
    {

        $lockTicket->setRedisLock($ticket);
        $ticket->amount = intval($ticket->amount);
        $reservation_id = Reservation::where('ticket_id', $ticket->id)->value('id');

        return view('ticket.purchase', ['ticket' => $ticket, 'reservation_id' => $reservation_id]);
    }


    public function cancelPurchase(Ticket $ticket, LockTicket $lockTicket)
    {
        $lockTicket->removeRedisLock($ticket);
        return redirect()->route('tickets')->with('message', 'Reservation canceled.');
    }
}
