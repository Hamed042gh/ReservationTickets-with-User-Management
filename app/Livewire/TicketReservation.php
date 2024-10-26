<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TicketReservation extends Component
{
    use WithPagination;

    // Initial properties
    public $user;
    public $previewReservation = false;
    public $selectedTicket;
    public $reservationData = [];
    public $searchByOrigin = '';
    public $searchByDestination = '';
    public $searchByReservation_date = '';

    public function mount()
    {
        $this->user = Auth::user(); // Get the authenticated user
    }

    public function handleMessageSubmission($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $this->selectedTicket = $ticket;
        $this->reservationData = [
            'user_id' => $this->user->id,
            'ticket_id' => $ticketId,
            'reservation_date' => $ticket->departure_date,
           
        ];

        $this->previewReservation = true; // Show the reservation preview
    }

    public function confirmReservation()
    {
        $ticket = $this->selectedTicket;

        if ($ticket && ($ticket->available_count) >= 1) {
       
         
          Reservation::create([
                'user_id' => $this->user->id,
                'ticket_id' => $ticket->id,
                'reservation_date' => $ticket->departure_date,
            ]);
            $this->resetPreview();
            session()->flash('message', 'Reserved successfully!');
            return redirect()->route('purchase', ['ticket' => $ticket]);

        } else {
            return redirect()->back()->with('error', 'No available seats for this ticket!'); // Error message
        }
    }

    public function resetPreview()
    {
        $this->previewReservation = false;
        $this->selectedTicket = null;
        $this->reservationData = [];
        session()->flash('message', 'Reservation canceled!');
    }

    public function search()
    {
        // Validate search input
        $this->validate([
            'searchByOrigin' => 'nullable|string|min:3',
            'searchByDestination' => 'nullable|string|min:3',
            'searchByReservation_date' => 'nullable|date',
        ]);
    }

    public function render()
    {
        $query = Ticket::query();

        // search && filters
        if (!empty($this->searchByOrigin)) {
            $query->where('origin', 'like', '%' . $this->searchByOrigin . '%');
        }

        if (!empty($this->searchByDestination)) {
            $query->where('destination', 'like', '%' . $this->searchByDestination . '%');
        }

        if (!empty($this->searchByReservation_date)) {
            $query->whereDate('departure_date', $this->searchByReservation_date);
        }

        // pagination
        $tickets = $query->paginate(6);

        return view('livewire.ticket-reservation', [
            'tickets' => $tickets,
        ]);
    }
}
