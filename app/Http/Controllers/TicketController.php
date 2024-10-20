<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function showTickets()
    {
        return view('ticket.index');
    }
}
