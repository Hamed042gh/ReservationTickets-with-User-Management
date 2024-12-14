<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Services\CacheTickets;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;


class ShowTickets extends Component
{
    use WithPagination;

    public $searchByOrigin = '';
    public $searchByDestination = '';
    public $searchByDate = '';

    // Initialize search parameters
    public function mount()
    {
        $this->resetSearch();
    }

    // Reset search filters
    public function resetSearch()
    {
        $this->searchByOrigin = '';
        $this->searchByDestination = '';
        $this->searchByDate = '';
    }

    // Handle updates to search filters
    #[On('searchTickets')]
    public function updatedSearch($searchMethod)
    {
        $this->searchByOrigin = $searchMethod['origin'];
        $this->searchByDestination = $searchMethod['destination'];
        $this->searchByDate = $searchMethod['date'];
    }


    // Render tickets based on search or cache
    public function render(CacheTickets $cacheTickets)
    {

        // If no search criteria, fetch tickets from cache
        if (empty($this->searchByOrigin) && empty($this->searchByDestination) && empty($this->searchByDate)) {

            $tickets =  $cacheTickets->cacheShowTickets();
        } else {

            // Filter tickets based on search criteria
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
        // Return tickets view with data
        return view('livewire.show-tickets', [
            'tickets' => $tickets,
            'noTicketsMessage' => $tickets->isEmpty() ? 'No tickets found!' : null,
        ]);
    }
}
