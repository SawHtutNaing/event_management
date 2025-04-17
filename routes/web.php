<?php

use App\Livewire\Admin\AdminRegistration;
use App\Livewire\Admin\Bookings as AdminBookings;
use App\Livewire\Admin\EventForm;
use App\Livewire\Admin\Events as AdminEvents;

use App\Livewire\BookingForm;
use App\Livewire\Calendar;
use App\Livewire\EventDetails;
use App\Livewire\EventList;
use App\Livewire\EventShow;
use App\Livewire\Home;
use App\Livewire\UserBookingIndex;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::get('/', Home::class)->name('home');

Route::get('/events', EventList::class)->name('events.index');

Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/events/{event}', EventShow::class)->name('events.show');
    Route::get('/calendar', Calendar::class)->name('calendar');
    Route::get('/booking-form/{event}', BookingForm::class)->name('booking-form');

    Route::get('/my-bookings', UserBookingIndex::class)->name('user_bookings');

    Route::get('/portal', function () {
        $user = User::find(auth()->id());
        if ($user->isAdmin()) {
            return redirect()->route('admin.events.index');
        } else {
            return redirect()->route('events.index');
        }
    })->name('portal');





    Route::get('/bookings', function () {
        $user = User::find(auth()->id());
        if ($user->isAdmin()) {
            return redirect()->route('admin.bookings.index');
        } else {
            return redirect()->route('user_bookings');
        }
    })->name('bookings');







});



//admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminEvents::class)->name('events.index');
        Route::get('/events/create', EventForm::class)->name('events.create');
        Route::get('/events/{event}/edit', EventForm::class)->name('events.edit');
        Route::get('/events/{event}', EventDetails::class)->name('events.details');

        Route::get('/bookings', AdminBookings::class)->name('bookings.index');

    });
Route::get('/profile', fn() => view('profile'))->name('profile');

Route::get('/register', AdminRegistration::class)->name('register');

require __DIR__ . '/auth.php';
