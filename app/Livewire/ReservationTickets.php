<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\Attributes\On;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\Log;
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

        if ($this->setRedisLock($ticket)) {
            $this->previewReservation = true;
        } else {
            $this->dispatch('showError', 'This ticket is currently being reserved by someone else. Please try again later.');
        }
    }

    public function confirmReservation()
    {
        $ticket = $this->selectedTicket;
        $userId = $this->user->id;
        $hasReserved = Reservation::where('ticket_id', $ticket->id)
            ->where('user_id', $userId )
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


            $this->resetPreview();
            $this->removeRedisLock();
            return redirect()->route('purchase', ['ticket' => $ticket]);
        } else {
            $this->removeRedisLock();
            return redirect()->back()->with('error', 'No available seats for this ticket!'); // پیغام خطا
        }
    }

    public function resetPreview()
    {
        $this->previewReservation = false;
        $this->selectedTicket = null;
        $this->reservationData = [];
        session()->flash('message', 'Reservation canceled!');
        $this->removeRedisLock();
    }

    private function setRedisLock($ticket)
    {
        $this->lockKey = 'ticket_lock_' . $ticket->id;
        $result = Redis::set($this->lockKey, 1, 'NX', 'EX', 30);
        session(['lockKey' => $this->lockKey]);
        Log::info("Lock key set: {$this->lockKey} is set");
        return $result;
    }

    private function removeRedisLock()
    {
        $this->lockKey = session('lockKey');
        if ($this->lockKey) {
            if (Redis::exists($this->lockKey)) {
                Redis::del($this->lockKey);
                Log::info("Lock key delete: {$this->lockKey}");
            }
        }
    }



    public function render()
    {
        return view('livewire.reservation-tickets');
    }
}
