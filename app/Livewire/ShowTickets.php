<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
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
    #[On('searchTickets')]
    public function updatedSearch($searchMethod)
    {
        $this->searchByOrigin = $searchMethod['origin'];
        $this->searchByDestination = $searchMethod['destination'];
        $this->searchByDate = $searchMethod['date'];
    }

    public function render()
    {
        $currentPage = request()->get('page', 1);

        if (empty($this->searchByOrigin) && empty($this->searchByDestination) && empty($this->searchByDate)) {
            $cacheKey = 'Cache:tickets_page_' . $currentPage;

            $tickets = Cache::remember($cacheKey, 600, function () {
                return Ticket::paginate(6);
            });
        } else {

            $query = Ticket::query();

            if (!empty($this->searchByOrigin)) {
                $query->where('origin', 'like', '%' . $this->searchByOrigin . '%');
            }
            if (!empty($this->searchByDestination)) {
                $query->where('destination', 'like', '%' . $this->searchByDestination . '%');
            }
            if (!empty($this->searchByDate)) {
                $query->whereDate('departure_date', $this->searchByDate);
            }

            $tickets = $query->paginate(6);
        }

        return view('livewire.show-tickets', [
            'tickets' => $tickets,
            'noTicketsMessage' => $tickets->isEmpty() ? 'No tickets found!' : null,
        ]);
    }
}
