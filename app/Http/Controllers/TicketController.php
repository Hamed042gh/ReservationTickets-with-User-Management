<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class TicketController extends Controller
{
    public function showTickets()
    {
        return view('ticket.index');
    }

    public function purchase(Ticket $ticket)
    {
        $lockKey = $this->setRedisLock($ticket);
        $ticket->amount = intval($ticket->amount);
        $reservation_id = Reservation::where('ticket_id', $ticket->id)->value('id');

        return view('ticket.purchase', ['ticket' => $ticket, 'reservation_id' => $reservation_id]);
    }

    private function setRedisLock($ticket)
    {
        $lockKey = 'Lock:ticket_' . $ticket->id;
        $result = Redis::set($lockKey, 1, 'NX', 'EX', 600);
        session(['lockKey' => $lockKey]);
        Log::info("Lock key set: {$lockKey} is set");
        return $result;
    }
}
