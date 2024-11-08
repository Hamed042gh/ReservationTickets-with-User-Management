<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;

class CacheTickets
{
    public function cacheShowTickets()
    {
        $currentPage = request()->get('page', 1);
        $cacheKey = 'Cache:tickets_page_' . $currentPage;

        return Cache::remember($cacheKey, 600, function () {
            return Ticket::paginate(6);
        });
    }
}
