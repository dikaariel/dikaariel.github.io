<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama kembali memakai template Garuda lama / static
Route::get('/', function () {
    return redirect('/garuda/index.html');
});

// Halaman daftar penerbangan untuk user
Route::get('/available-flights', [FlightController::class, 'available'])->name('flights.available');

// Dashboard setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route yang wajib login
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin CRUD Data Penerbangan
    |--------------------------------------------------------------------------
    */
    Route::resource('admin/flights', FlightController::class)->names('flights');

    /*
    |--------------------------------------------------------------------------
    | Booking User
    |--------------------------------------------------------------------------
    */

    // Pilih kelas tiket: Economy / Business
    Route::get('/booking/{flight}/tiers', [BookingController::class, 'tiers'])->name('booking.tiers');

    // Pilih kursi
    Route::get('/booking/{flight}/seats', [BookingController::class, 'seats'])->name('booking.seats');

    // Form data penumpang / passenger details
    Route::get('/booking/{flight}', [BookingController::class, 'create'])->name('booking.create');

    // Simpan data booking ke database
    Route::post('/booking/{flight}', [BookingController::class, 'store'])->name('booking.store');

    // Halaman booking berhasil
    Route::get('/booking-success/{booking}', [BookingController::class, 'success'])->name('booking.success');

    // Halaman riwayat booking user
    Route::get('/my-booking', [BookingController::class, 'index'])->name('booking.index');

    /*
    |--------------------------------------------------------------------------
    | Profile User
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';