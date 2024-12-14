<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class LockTicket
{
    public function isTicketLocked($ticket)
    {
        $lockKey = 'Lock:ticket_' . $ticket->id;
        return Redis::exists($lockKey) > 0;
    }

    public function setRedisLock($ticket)
    {
        $lockKey = 'Lock:ticket_' . $ticket->id;


        $result = Redis::set($lockKey, 1, 'NX', 'EX', 600);
        Log::info("Lock key set: {$lockKey} is set");
        return $result;
    }


    public function removeRedisLock($ticket)
    {
        $lockKey = 'Lock:ticket_' . $ticket->id;
        if (Redis::exists($lockKey)) {
            Redis::del($lockKey);
            Log::info("Lock key delete: {$lockKey}");
        }
    }
}
