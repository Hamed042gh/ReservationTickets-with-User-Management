<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\Attributes\On;
use App\Enums\ReservationStatus;
use App\Services\LockTicket;
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

    // Handle the reservation request when user submits the "reserve" action
    #[On('reserve')]
    public function handleMessageSubmission($ticketId, LockTicket $lockTicket)
    {
        if (!$this->user) {
            return redirect('/login');
        }

        $ticket = Ticket::findOrFail($ticketId);

        if ($this->isTicketAvailable($ticket)) {
            $this->setReservationData($ticket);
            if ($lockTicket->setRedisLock($ticket)) {
                $this->previewReservation = true;
            } else {
                $this->dispatch('showError', 'This ticket is currently being reserved by someone else. Please try again later.');
            }
        } else {
            $this->dispatch('showError', 'No available seats for this ticket!');
        }
    }

    // Helper function to check if a ticket is available
    private function isTicketAvailable($ticket)
    {
        return $ticket->available_count > 0;
    }

    // Set the reservation data based on the selected ticket
    private function setReservationData($ticket)
    {
        $this->selectedTicket = $ticket;
        $this->reservationData = [
            'user_id' => $this->user->id,
            'ticket_id' => $ticket->id,
            'reservation_date' => $ticket->departure_date,
        ];
    }

    // Confirm the reservation and create the reservation record
    public function confirmReservation(LockTicket $lockTicket)
    {
        $ticket = $this->selectedTicket;
        $userId = $this->user->id;
        $hasReserved = Reservation::where('ticket_id', $ticket->id)
            ->where('user_id', $userId)
            ->where('status', ReservationStatus::RESERVED->value)
            ->exists();

        if ($hasReserved) {

            return redirect()->back()->with('error', 'This ticket has already been reserved!');
        }
        if ($ticket && $ticket->available_count >= 1) {

            Reservation::create([
                'user_id' => $this->user->id,
                'ticket_id' => $ticket->id,
                'reservation_date' => $ticket->departure_date,
            ]);

            return redirect()->route('purchase', ['ticket' => $ticket]);
        } else {
            // If ticket is no longer available, remove the Redis lock and show an error
            $lockTicket->removeRedisLock($ticket);
            return redirect()->back()->with('error', 'No available seats for this ticket!'); // پیغام خطا
        }
    }

    // Reset the reservation preview and clear the selected ticket
    public function resetPreview(LockTicket $lockTicket)
    {
        $this->previewReservation = false;

        $this->reservationData = [];
        session()->flash('message', 'Reservation canceled!');
        if ($this->selectedTicket) {
            // Remove the Redis lock for the ticket and reset selected ticket
            $lockTicket->removeRedisLock($this->selectedTicket);
            $this->selectedTicket = null;
        }
    }

    public function render()
    {
        return view('livewire.reservation-tickets');
    }
}
