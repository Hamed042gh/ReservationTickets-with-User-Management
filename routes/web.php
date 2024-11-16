<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserReservationsController;

Route::get('/', function () {
    return cache()->remember('home_page', now()->addMinutes(60), function () {
        return view('welcome')->render();
    });
});

// general
Route::get('/tickets', [TicketController::class, 'showTickets'])->name('tickets');

// group with autentication
Route::middleware(['auth'])->group(function () {

    // users
    Route::view('dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    // Reservations & Payments
    Route::get('/purchase/{ticket}', [TicketController::class, 'purchase'])
        ->middleware('Check.Reservation')
        ->name('purchase');

    Route::get('/cancelpurchase/{ticket}', [TicketController::class, 'cancelPurchase'])
        ->middleware('Check.Reservation')
        ->name('cancelPurchase');

    Route::get('/reservations', [UserReservationsController::class, 'showReservations'])
        ->name('reservations');

    Route::get('/finance', [UserReservationsController::class, 'showFinance'])
        ->name('finance');

    Route::delete('reservations/delete/{id}', [UserReservationsController::class, 'deleteReservation'])
        ->name('deleteReservation');

    // payments
    Route::prefix('payment')->group(function () {
        Route::post('/request', [PaymentController::class, 'requestPayment']);
        Route::get('/callback', [PaymentController::class, 'verifyPayment']);
        Route::post('/verify', [PaymentController::class, 'verifyPayment']);
        Route::post('/inquiry', [PaymentController::class, 'inquiryPayment'])->name('payment.inquiry');
    });
});

// Autentication
require __DIR__ . '/auth.php';

// Broadcast routes
Broadcast::routes(['middleware' => ['web', 'auth']]);
