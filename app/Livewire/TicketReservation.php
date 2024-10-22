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
    public $searchTerm;
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
            session()->flash('message', 'reserved successfully!');
        } else {
            return redirect()->back()->with('error', 'No available seats for this ticket!');
        }
    }

    public function resetPreview()
    {

        $this->previewReservation = false;
        $this->selectedTicket = null;
        $this->reservationData = [];
        session()->flash('message', 'Reservation cancled!');
    }


    public function search()
    {
        $this->validate([
            'searchByOrigin' => 'nullable|string|min:3',
            'searchByDestination' => 'nullable|string|min:3',
            'searchByReservation_date' => 'nullable|date',
        ]);

        $query = Ticket::query();

        //search with Origin
        if (!empty($this->searchByOrigin)) {
            $query->where('origin', 'like', '%' . $this->searchByOrigin . '%');
        }

        //search with searchByDestination
        if (!empty($this->searchByDestination)) {
            $query->where('destination', 'like', '%' . $this->searchByDestination . '%');
        }
        //search with searchByReservation_date
        if (!empty($this->searchByReservation_date)) {
            $query->whereDate('departure_date', $this->searchByReservation_date);
        }

        $this->tickets = $query->get();

        if ($this->tickets->isEmpty()) {
            session()->flash('message', 'No tickets found for your search!');
        }
    }

    public function render()
    {
        return view('livewire.ticket-reservation', [
            'tickets' => $this->tickets
        ]);
    }
}
