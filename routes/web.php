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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([])->group(function () {
    // Route::get('/events.index', function () {
    //     return view('events.index');
    // })->name('events.index');

    // User routes
    Route::get('/events', EventList::class)->name('events.index');
    Route::get('/events/{event}', EventShow::class)->name('events.show');
    Route::get('/calendar', Calendar::class)->name('calendar');
});



//admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/events.index', function () {
        return view('admin.events.index');
    })->name('events.index');

    Route::get('/', AdminEvents::class)->name('events.index');
    Route::get('/events/create', EventForm::class)->name('events.create');
    Route::get('/events/{event}/edit', EventForm::class)->name('events.edit');
    Route::get('/events/{event}',EventDetails::class)->name('events.details');

    Route::get('/bookings', AdminBookings::class)->name('bookings.index');

});
Route::get('/profile',fn()=> view('profile'))->name('profile');

Route::get('/register', AdminRegistration::class)->name('register');

require __DIR__.'/auth.php';
