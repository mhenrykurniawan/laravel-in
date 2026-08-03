<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//////////////////

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('bookings', BookingController::class);
});

Route::middleware(['auth', 'role:Admin'])->group(function () {

    // CRUD Ruang
    Route::resource('rooms', RoomController::class);
    Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approve'])
        ->name('bookings.approve');

    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])
        ->name('bookings.reject');
});

Route::middleware(['auth', 'role:Dosen'])->group(function () {

    // Pengajuan


});


require __DIR__ . '/auth.php';
