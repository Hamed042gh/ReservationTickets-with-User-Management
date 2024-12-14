<?php

namespace App\Livewire;

use Livewire\Component;


class SearchTickets extends Component
{

    public $searchByOrigin = '';
    public $searchByDestination = '';
    public $searchByReservation_date = '';


    public function updated($searchMethod)
    {
       
        // Validate search input
        $this->validateOnly($searchMethod, [
            'searchByOrigin' => 'nullable|string|min:3',
            'searchByDestination' => 'nullable|string|min:3',
            'searchByReservation_date' => 'nullable|date',
        ]);
        
    }
    
    public function search()
    {
        $this->dispatch('searchTickets', [
            'origin' => $this->searchByOrigin,
            'destination' => $this->searchByDestination,
            'date' => $this->searchByReservation_date,
        ]);
       
    }

    public function render()
    {
        return view('livewire.search-tickets');
    }
}
