<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guest\EventController as GuestEventController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\OrderController as UserOrderController;

use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\OrganizerRequestController;
use App\Http\Controllers\Organizer\OrgEventController;
use App\Http\Controllers\Organizer\TicketController as OrganizerTicketController;
use App\Http\Controllers\Organizer\OrderController as OrganizerOrderController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

    Route::get('/', [GuestEventController::class, 'home'])->name('home');

// Guest
Route::prefix('guest')->name('guest.')->group(function () {
    Route::get('/events', [GuestEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [GuestEventController::class, 'show'])->name('events.show');
});

require __DIR__ . '/auth.php';

// Organizer
Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/pending', [OrganizerRequestController::class, 'pending'])->name('organizer.pending');
    Route::get('/organizer/rejected', [OrganizerRequestController::class, 'rejected'])->name('organizer.rejected');
    Route::delete('/organizer/delete-account', [OrganizerRequestController::class, 'deleteAccount'])->name('organizer.delete-account');
    Route::post('/organizer/request', [OrganizerRequestController::class, 'store'])->name('organizer.request');
});


// USer
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User home
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserEventController::class, 'home'])->name('home');
    });

    // Events
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [UserEventController::class, 'index'])->name('index');
        Route::get('/search', [UserEventController::class, 'search'])->name('search');
        Route::get('/category/{category:slug}', [UserEventController::class, 'byCategory'])->name('category');
        Route::get('/{event}', [UserEventController::class, 'show'])->name('show');
    });

    // Favorites
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('index');
        Route::post('/{event}', [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{event}', [FavoriteController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::get('/count', [FavoriteController::class, 'count'])->name('count');
        Route::delete('/', [FavoriteController::class, 'clear'])->name('clear');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [UserOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [UserOrderController::class, 'show'])->name('show');
        Route::get('/{order}/cancel', [UserOrderController::class, 'showCancelForm'])->name('cancel.confirm');
        Route::delete('/{order}/cancel', [UserOrderController::class, 'cancel'])->name('cancel');
    });

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/events/{event}/tickets/{ticket}/checkout', [BookingController::class, 'create'])->name('create');
        Route::post('/events/{event}/tickets/{ticket}/book', [BookingController::class, 'store'])->name('store');
        Route::get('/{order}', [BookingController::class, 'show'])->name('show');
    });
});


// Organizer
Route::middleware(['auth', 'verified', 'organizer'])
    ->prefix('organizer')
    ->name('organizer.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Events
        Route::resource('events', OrgEventController::class);

        // Tickets
        Route::prefix('events/{event}/tickets')->name('tickets.')->group(function () {
            Route::get('/', [OrganizerTicketController::class, 'index'])->name('index');
            Route::get('/create', [OrganizerTicketController::class, 'create'])->name('create');
            Route::post('/', [OrganizerTicketController::class, 'store'])->name('store');
            Route::get('/{ticket}/edit', [OrganizerTicketController::class, 'edit'])->name('edit');
            Route::put('/{ticket}', [OrganizerTicketController::class, 'update'])->name('update');
            Route::delete('/{ticket}', [OrganizerTicketController::class, 'destroy'])->name('destroy');
            Route::post('/{ticket}/toggle', [OrganizerTicketController::class, 'toggleActive'])->name('toggle');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrganizerOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrganizerOrderController::class, 'show'])->name('show');
            Route::post('/{order}/approve', [OrganizerOrderController::class, 'approve'])->name('approve');
            Route::post('/{order}/cancel', [OrganizerOrderController::class, 'cancel'])->name('cancel');
        });
    });


// Admin
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::patch('/{user}/approve', [UserController::class, 'approve'])->name('approve');
            Route::patch('/{user}/reject', [UserController::class, 'reject'])->name('reject');
        });

        // Events
        Route::resource('events', AdminEventController::class);
        Route::get('events/create', [AdminEventController::class, 'create'])->name('events.create');

        // Pending event first-ticket creation
        Route::get('tickets/create-for-pending-event', [AdminTicketController::class, 'createForPendingEvent'])
            ->name('tickets.create_for_pending_event');
        Route::post('tickets/store-with-pending-event', [AdminTicketController::class, 'storeWithPendingEvent'])
            ->name('tickets.store_with_pending_event');

        // Tickets
        Route::prefix('events/{event}/tickets')->name('tickets.')->group(function () {
            Route::get('/', [AdminTicketController::class, 'index'])->name('index');
            Route::get('/create', [AdminTicketController::class, 'create'])->name('create');
            Route::post('/', [AdminTicketController::class, 'store'])->name('store');
            Route::get('/{ticket}/edit', [AdminTicketController::class, 'edit'])->name('edit');
            Route::put('/{ticket}', [AdminTicketController::class, 'update'])->name('update');
            Route::delete('/{ticket}', [AdminTicketController::class, 'destroy'])->name('destroy');
            Route::post('/{ticket}/toggle', [AdminTicketController::class, 'toggleActive'])->name('toggle');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
            Route::post('/{order}/approve', [AdminOrderController::class, 'approve'])->name('approve');
            Route::post('/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('cancel');
        });

        // Reports
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    });
