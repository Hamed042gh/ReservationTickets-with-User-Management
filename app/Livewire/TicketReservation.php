<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class TicketReservation extends Component
{

    //initial property
    public $user;
    public $tickets;
    public $previewReservation = false;
    public $selectedTicket;
    public $reservationData = [];
    public $searchByOrigin;
    public $searchByDestination;
    public $searchByReservation_date;

    public function mount()
    {
        $this->user = Auth::user();
        $this->tickets = Ticket::all();
        $this->searchByOrigin = '';
        $this->searchByDestination = '';
        $this->searchByReservation_date = '';
    }

    public function handleMessageSubmission($ticketId)
    {

        $ticket = Ticket::findOrfail($ticketId);

        $this->selectedTicket = $ticket;
        $this->reservationData = [
            'user_id' => $this->user->id,
            'ticket_id' => $ticketId,
            'reservation_date' => $ticket->departure_date,
        ];

        $this->previewReservation = true;
    }

    public function confirmReservation()
    {
        $ticket = $this->selectedTicket;
        if ($ticket && ($ticket->available_count) >= 1) {
            $reservation = Reservation::create([
                'user_id' => $this->user->id,
                'ticket_id' => $ticket->id,
                'reservation_date' => $ticket->departure_date

            ]);
            $this->resetPreview();
            return redirect()->back()->with('message', 'reserved successfully!');
        } else {
            return redirect()->back()->with('error', 'No available seats for this ticket!');
        }
    }
    public function resetPreview()
    {

        $this->previewReservation = false;
        $this->selectedTicket = null;
        $this->reservationData = [];
        return redirect()->back()->with('error', 'Reservation canceled!');
    }





    public function render()
    {
        return view('livewire.ticket-reservation', [
            'tickets' => $this->tickets,
            'reservationData' => $this->reservationData,
        ]);
    }
}
