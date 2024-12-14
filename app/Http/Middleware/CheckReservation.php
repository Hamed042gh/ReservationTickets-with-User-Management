<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckReservation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $ticketId = $request->route('ticket')->id;

        $reservations = Reservation::where('user_id', Auth::id())
            ->where('status', 1)
            ->where('ticket_id', $ticketId)
            ->get();
        if (!$reservations->isEmpty()) {

            return redirect('/tickets')->with('error', 'its reserved!!');
        }

        return $next($request);
    }
}
