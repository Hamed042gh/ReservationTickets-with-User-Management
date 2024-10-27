<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ShowTickets extends Component
{
    use WithPagination;

    // Initial properties
    public $searchByOrigin = '';
    public $searchByDestination = '';
    public $searchByDate = '';

    public function mount()
    {
        // Initial state for search
        $this->resetSearch();
    }

    // Reset search filters
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
        $query = Ticket::query();

        // Check if search criteria are provided
        if (!empty($this->searchByOrigin) || !empty($this->searchByDestination) || !empty($this->searchByDate)) {
            // Apply filters based on search criteria
            if (!empty($this->searchByOrigin)) {
                $query->where('origin', 'like', '%' . $this->searchByOrigin . '%');
            }

            if (!empty($this->searchByDestination)) {
                $query->where('destination', 'like', '%' . $this->searchByDestination . '%');
            }

            if (!empty($this->searchByDate)) {
                $query->whereDate('departure_date', $this->searchByDate);
            }
        }

        // Get paginated results    
        $tickets = $query->paginate(6);

        return view('livewire.show-tickets', [
            'tickets' => $tickets,
            'noTicketsMessage' => $tickets->isEmpty() ? 'no Tickets found!!' : null,
        ]);
    }
}
