<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ReservationTickets extends Component
{

    public $user;
    public $previewReservation = false;
    public $selectedTicket;
    public $reservationData = [];


    public function mount()
    {
        $this->user = Auth::user(); // Get the authenticated user
    }


    #[On('reserve')]
    public function handleMessageSubmission($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        if (($ticket->available_count) < 1) {
            $this->dispatch('showError', 'No available seats for this ticket!');
            return;
        }
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

    public function render()
    {
        return view('livewire.reservation-tickets');
    }
}
