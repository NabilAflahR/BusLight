<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AdminBookingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/filter-schedules', [LandingController::class, 'filter'])->name('landing.filter');

Route::post('/xendit/callback', [PaymentController::class, 'handleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/buses',BusController::class);
    Route::resource('/routes', RouteController::class);
    Route::resource('/schedules', ScheduleController::class);
    Route::resource('/bookings', AdminBookingController::class);
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

});

Route::middleware(['auth', 'role:user'])->group(function() {
    Route::get('/user/dashboard', [UserDashboardController::class, 'landing'])->name('user.dashboard');
    Route::get('/user/booking/{schedule_id}', [UserDashboardController::class, 'showBookingForm'])->name('user.booking.form');
    Route::post('/user/booking/create', [BookingController::class, 'CreateBooking'])->name('user.booking.create');

    // 🔥 INI yang benar:
    Route::get('/user/payment/{booking_id}', [PaymentController::class, 'createPayment'])
        ->name('user.payment.create');

    Route::post('/user/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('user.bookings.cancel');
    Route::get('/user/booking/{id}', [BookingController::class, 'show'])->name('user.booking.show');
    Route::get('/user/tickets/{booking_id}', [TicketController::class, 'issueTicket'])->name('user.tickets.show');
    Route::get('/user/booking_history', [BookingController::class, 'history'])->name('user.booking_history');
});

Route::get('/user/bookings/{booking_id}/ticket', [TicketController::class, 'issueTicket'])
     ->name('user.tickets.issue');
require __DIR__.'/auth.php';
