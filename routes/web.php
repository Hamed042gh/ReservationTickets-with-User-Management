<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/tickets',[TicketController::class,'showTickets'])->name('tickets');
Route::get('/purchase{ticket}',[TicketController::class,'purchase'])->name('purchase');

Route::middleware(['auth'])->group(function () {
    Route::post('/payment/request', [PaymentController::class, 'requestPayment']);
    Route::get('/payment/callback', [PaymentController::class, 'verifyPayment']);
    Route::post('/payment/verify', [PaymentController::class, 'verifyPayment']);
    Route::post('/payment/inquiry', [PaymentController::class, 'inquiryPayment'])->name('payment.inquiry');
});