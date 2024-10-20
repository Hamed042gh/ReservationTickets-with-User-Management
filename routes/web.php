<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/tickets',[TicketController::class,'showTickets'])->name('tickets');