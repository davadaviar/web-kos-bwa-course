<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/find-kos', [BoardingHouseController::class, 'findKos'])->name('find.kos');
Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('check.booking');
