<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ShowTickets extends Component
{
    use WithPagination;

    public $searchByOrigin = '';
    public $searchByDestination = '';
    public $searchByDate = '';

    public function mount()
    {
        $this->resetSearch();
    }

    public function resetSearch()
    {
        $this->searchByOrigin = '';
        $this->searchByDestination = '';
        $this->searchByDate = '';
    }

    public function updatedSearch($searchMethod)
    {
        $this->searchByOrigin = $searchMethod['origin'];
        $this->searchByDestination = $searchMethod['destination'];
        $this->searchByDate = $searchMethod['date'];
    }

    public function render()
    {
        $tickets = Cache::remember('allTicketsShow', 600, function () {
            $query = Ticket::query();

            return $query->paginate(6);
        });

        Log::info('Retrieved tickets: ', $tickets->toArray()); // بررسی بلیط‌ها
        Log::info('Cache allTickets: ' . Cache::get('allTickets'));

        return view('livewire.show-tickets', [
            'tickets' => $tickets,
            'noTicketsMessage' => $tickets->isEmpty() ? 'No tickets found!' : null,
        ]);
    }
}
