<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserReservationsController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';



Route::middleware(['auth'])->group(function () {

    Route::get('/purchase{ticket}', [TicketController::class, 'purchase'])->middleware('Check.Reservation')->name('purchase');
    Route::get('/cancelpurchase{ticket}', [TicketController::class, 'cancelPurchase'])->middleware('Check.Reservation')->name('cancelPurchase');
    Route::get('/reservations', [UserReservationsController::class, 'showReservations'])->name('reservations');
    Route::get('/finance', [UserReservationsController::class, 'showFinance'])->name('finance');
});
Route::get('/tickets', [TicketController::class, 'showTickets'])->name('tickets');

Route::middleware(['auth'])->group(function () {
    Route::post('/payment/request', [PaymentController::class, 'requestPayment']);
    Route::get('/payment/callback', [PaymentController::class, 'verifyPayment']);
    Route::post('/payment/verify', [PaymentController::class, 'verifyPayment']);
    Route::post('/payment/inquiry', [PaymentController::class, 'inquiryPayment'])->name('payment.inquiry');
});
