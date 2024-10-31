<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ReservationTickets extends Component
{

    public $user;
    public $previewReservation = false;
    public $selectedTicket;
    public $reservationData = [];
    private $lockKey;

    public function mount()
    {
        $this->user = Auth::user(); // Get the authenticated user
    }


    #[On('reserve')]
    public function handleMessageSubmission($ticketId)
    {
        if (!$this->user) {
            return redirect('/login');
        }


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

        if (!$this->setRedisLock($ticket)) {

            return redirect()->back()->with('error', 'This ticket is currently being reserved by someone else. Please try again later.');
        }

        if ($ticket && ($ticket->available_count) >= 1) {


            Reservation::create([
                'user_id' => $this->user->id,
                'ticket_id' => $ticket->id,
                'reservation_date' => $ticket->departure_date,
            ]);
            $this->resetPreview();
            Redis::del($this->lockKey);
            return redirect()->route('purchase', ['ticket' => $ticket]);
        } else {
            Redis::del($this->lockKey);
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

    private function setRedisLock($ticket)
    {

        $lockKey = 'ticket_lock_' . $ticket->id;
        $lock = Redis::set($lockKey, 1, 'NX', 'EX', 10);
    }
    public function render()
    {
        return view('livewire.reservation-tickets');
    }
}
