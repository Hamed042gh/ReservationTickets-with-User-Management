<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function showTickets()
    {
        $tickets = Ticket::paginate(6);
        return view('ticket.index',compact('tickets'));
    }
}
