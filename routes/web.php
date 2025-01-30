<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/city/{slug}', [CityController::class, 'show'])->name('city.show');

Route::get('/kos/{slug}', [BoardingHouseController::class, 'show'])->name('kos.show');
Route::get('/kos/{slug}/rooms', [BoardingHouseController::class, 'rooms'])->name('kos.rooms');

Route::get('/find-kos', [BoardingHouseController::class, 'findKos'])->name('find.kos');
Route::get('/find-kos-result', [BoardingHouseController::class, 'findKosResult'])->name('find.kos.result');

Route::get('/kos/booking/{slug}', [BookingController::class, 'booking'])->name('booking');
Route::get('/kos/booking/{slug}/information', [BookingController::class, 'bookingInformation'])->name('booking.information');
Route::post('/kos/booking/{slug}/information/store', [BookingController::class, 'bookingInformationStore'])->name('booking.information.store');
Route::get('/kos/booking/{slug}/checkout', [BookingController::class, 'bookingCheckout'])->name('booking.checkout');
Route::post('/kos/booking/{slug}/payment', [BookingController::class, 'bookingPayment'])->name('booking.payment');
Route::get('/booking-success', [BookingController::class, 'bookingSuccess'])->name('booking.success');

Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('check.booking');
