<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Organizer\OrganizerRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guest\EventController as GuestEventController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Organizer\OrgEventController;
use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\TicketController as OrganizerTicketController;
use App\Http\Controllers\Organizer\OrderController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;

// ========================================
// GUEST ROUTES (Public - Tanpa Login)
// ========================================

Route::name('guest.')->group(function () {
    Route::get('/', [GuestEventController::class, 'home'])->name('home');
    Route::get('/events', [GuestEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [GuestEventController::class, 'show'])->name('events.show');
});

// ========================================
// AUTH ROUTES (Login/Register - dari Breeze)
// ========================================
require __DIR__.'/auth.php';

// ========================================
// ORGANIZER STATUS ROUTES (Pending/Rejected)
// ========================================

Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/pending', [OrganizerRequestController::class, 'pending'])
        ->name('organizer.pending');
    
    Route::get('/organizer/rejected', [OrganizerRequestController::class, 'rejected'])
        ->name('organizer.rejected');
    
    Route::delete('/organizer/delete-account', [OrganizerRequestController::class, 'deleteAccount'])
        ->name('organizer.delete-account');
        
    Route::post('/organizer/request', [OrganizerRequestController::class, 'store'])
        ->name('organizer.request');
});

// ========================================
// AUTHENTICATED USER ROUTES
// ========================================

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Cek status pending/rejected PERTAMA
        if ($user->status === 'pending') {
            return redirect()->route('organizer.pending');
        }
        
        if ($user->status === 'rejected') {
            return redirect()->route('organizer.rejected');
        }
        
        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'organizer') {
            return redirect()->route('organizer.dashboard');
        } else {
            return redirect()->route('user.home');
        }
    })->name('dashboard');

    // Profile Routes (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // USER ROUTES GROUP
    Route::prefix('user')->name('user.')->group(function () {
        // HOME
        Route::get('/', [UserEventController::class, 'home'])->name('home');
        
        // Events
        Route::get('/events', [UserEventController::class, 'index'])->name('events.index');
        Route::get('/events/search', [UserEventController::class, 'search'])->name('events.search');
        Route::get('/events/category/{category:slug}', [UserEventController::class, 'byCategory'])->name('events.category');
        Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');
        
        // Favorites
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
        Route::post('/favorites/{event}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/favorites/{event}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
        Route::post('/favorites/{event}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');
        Route::delete('/favorites', [FavoriteController::class, 'clear'])->name('favorites.clear');
        
        // Orders
        Route::get('/orders', [UserOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/orders/{order}/download-ticket', [UserOrderController::class, 'downloadTicket'])->name('orders.download-ticket');
        Route::get('/orders/statistics', [UserOrderController::class, 'statistics'])->name('orders.statistics');
    });

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/events/{event}/tickets/{ticket}/checkout', [BookingController::class, 'create'])->name('create');
        Route::post('/events/{event}/tickets/{ticket}/book', [BookingController::class, 'store'])->name('store');
        Route::get('/{order}', [BookingController::class, 'show'])->name('show');
    });
});

// ========================================
// ORGANIZER ROUTES
// ========================================

Route::middleware(['auth', 'verified', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Events Management
    Route::get('/events', [OrgEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [OrgEventController::class, 'create'])->name('events.create');
    Route::post('/events', [OrgEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [OrgEventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [OrgEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [OrgEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [OrgEventController::class, 'destroy'])->name('events.destroy');

    // Tickets Management untuk ORGANIZER
    Route::prefix('events/{event}/tickets')->name('tickets.')->group(function () {
        Route::get('/', [OrganizerTicketController::class, 'index'])->name('index');
        Route::get('/create', [OrganizerTicketController::class, 'create'])->name('create');
        Route::post('/', [OrganizerTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}/edit', [OrganizerTicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [OrganizerTicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}', [OrganizerTicketController::class, 'destroy'])->name('destroy');
        Route::post('/{ticket}/toggle', [OrganizerTicketController::class, 'toggleActive'])->name('toggle');
    });

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/approve', [OrderController::class, 'approve'])->name('approve');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });
});

// ========================================
// ADMIN ROUTES
// ========================================

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');

    // Events Management
    Route::resource('events', AdminEventController::class);

    // Tickets Management untuk ADMIN
    Route::prefix('events/{event}/tickets')->name('tickets.')->group(function () {
        Route::get('/', [AdminTicketController::class, 'index'])->name('index');
        Route::get('/create', [AdminTicketController::class, 'create'])->name('create');
        Route::post('/', [AdminTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}/edit', [AdminTicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [AdminTicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}', [AdminTicketController::class, 'destroy'])->name('destroy');
        Route::post('/{ticket}/toggle', [AdminTicketController::class, 'toggleActive'])->name('toggle');
    });

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/sales', [AdminReportController::class, 'sales'])->name('sales');
        Route::get('/events', [AdminReportController::class, 'events'])->name('events');
        Route::get('/users', [AdminReportController::class, 'users'])->name('users');
    });
});