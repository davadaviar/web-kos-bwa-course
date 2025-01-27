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

Route::get('/find-kos', [BoardingHouseController::class, 'findKos'])->name('find.kos');
Route::get('/find-kos-result', [BoardingHouseController::class, 'findKosResult'])->name('find.kos.result');

Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('check.booking');
