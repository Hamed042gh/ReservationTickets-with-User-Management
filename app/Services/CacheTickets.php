<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CacheTickets
{
    
    public function cacheShowTickets()
    {
        $currentPage = request()->get('page', 1);
        $cacheKey = 'Cache:tickets_page_' . $currentPage;

        return Cache::remember($cacheKey, 600, function () use ($cacheKey) {
            Log::info("{$cacheKey} is set");
            return Ticket::paginate(6);
        });
    }

    public function clearCache()
    {
        $keys = Cache::getRedis()->keys('Cache:tickets_page_*');

        foreach ($keys as $key) {
            Cache::forget($key); // Clear the cache for each key
            Log::info("{$key} is cleared");
        }
    }
}
