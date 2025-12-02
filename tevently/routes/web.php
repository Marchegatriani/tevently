<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guest\EventController as GuestEventController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\TicketController as UserTicketController;

use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\OrganizerRequestController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\TicketController as OrganizerTicketController;
use App\Http\Controllers\Organizer\OrderController as OrganizerOrderController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;


Route::get('/', [GuestEventController::class, 'home'])->name('guests.home');
Route::get('/events', [GuestEventController::class, 'index'])->name('guests.events.index');
Route::get('/events/{event}', [GuestEventController::class, 'show'])->name('guests.events.show');


require __DIR__ . '/auth.php';

// User
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserEventController::class, 'home'])->name('home');
        
    });

    Route::prefix('user.events')->name('user.events.')->group(function () {
        Route::get('/', [UserEventController::class, 'index'])->name('index');
        Route::get('/search', [UserEventController::class, 'search'])->name('search');
        Route::get('/category/{category:slug}', [UserEventController::class, 'byCategory'])->name('category');
        Route::get('/{event}', [UserEventController::class, 'show'])->name('show');
    });

    Route::prefix('user/favorites')->name('user.favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('index');
        Route::post('/{event}/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::post('/{event}', [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{event}', [FavoriteController::class, 'destroy'])->name('destroy');
        Route::get('/count', [FavoriteController::class, 'count'])->name('count');
        Route::delete('/clear', [FavoriteController::class, 'clear'])->name('clear');
    });

   Route::prefix('user')->name('user.')->group(function () {
        Route::resource('orders', UserOrderController::class)->except(['create', 'store']);
        
        Route::get('events/{event}/tickets/{ticket}/book', [UserOrderController::class, 'create'])->name('orders.create');
        Route::post('events/{event}/tickets/{ticket}/book', [UserOrderController::class, 'store'])->name('orders.store');
        Route::post('orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
    });

    Route::get('/my-ticket/{orderItem}', [UserTicketController::class, 'show'])
     ->name('user.tickets');
});


// Organizer
Route::middleware(['auth', 'verified', 'organizer'])
    ->prefix('organizer')
    ->name('organizer.')
    ->group(function () {

    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', OrganizerEventController::class);
    
    Route::get('/organizer/pending', [OrganizerRequestController::class, 'pending'])->name('organizer.pending');
    Route::get('/organizer/rejected', [OrganizerRequestController::class, 'rejected'])->name('organizer.rejected');
    Route::delete('/organizer/delete-account', [OrganizerRequestController::class, 'deleteAccount'])->name('organizer.delete-account');
    Route::post('/organizer/request', [OrganizerRequestController::class, 'store'])->name('organizer.request');
        
    Route::prefix('events/{event}/tickets')->name('tickets.')->group(function () {
        Route::get('/', [OrganizerTicketController::class, 'index'])->name('index');
        Route::get('/create', [OrganizerTicketController::class, 'create'])->name('create');
        Route::post('/', [OrganizerTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}/edit', [OrganizerTicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [OrganizerTicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}', [OrganizerTicketController::class, 'destroy'])->name('destroy');
        Route::post('/{ticket}/toggle', [OrganizerTicketController::class, 'toggleActive'])->name('toggle');
    });

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

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{user}/approve', [UserController::class, 'approve'])->name('approve');
        Route::patch('/{user}/reject', [UserController::class, 'reject'])->name('reject');
    });

    Route::resource('events', AdminEventController::class);
    Route::get('events/create', [AdminEventController::class, 'create'])->name('events.create');

    Route::get('tickets/create-for-pending-event', [AdminTicketController::class, 'createForPendingEvent'])
        ->name('tickets.create_for_pending_event');
    Route::post('tickets/store-with-pending-event', [AdminTicketController::class, 'storeWithPendingEvent'])
        ->name('tickets.store_with_pending_event');

    Route::prefix('events/{event}/tickets')->name('tickets.')->group(function () {
        Route::get('/', [AdminTicketController::class, 'index'])->name('index');
        Route::get('/create', [AdminTicketController::class, 'create'])->name('create');
        Route::post('/', [AdminTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}/edit', [AdminTicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [AdminTicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}', [AdminTicketController::class, 'destroy'])->name('destroy');
        Route::post('/{ticket}/toggle', [AdminTicketController::class, 'toggleActive'])->name('toggle');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{order}/approve', [AdminOrderController::class, 'approve'])->name('approve');
        Route::post('/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('cancel');
    });

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
});
