<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateTicketsCount implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }


    //event
    public function broadcastAs()
    {
        return 'UpdateTicketsCount';
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('tickets'),
        ];
    }
}
