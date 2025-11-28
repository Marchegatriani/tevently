<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizerRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Organizer\OrgEventController;
use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Organizer\OrderController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;

// ========================================
// GUEST ROUTES (Public - Tanpa Login)
// ========================================

Route::get('/', [EventController::class, 'home'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// ========================================
// AUTH ROUTES (Login/Register - dari Breeze)
// ========================================
require __DIR__.'/auth.php';

// ========================================
// AUTHENTICATED USER ROUTES
// ========================================

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'organizer') {
            return redirect()->route('organizer.dashboard');
        } else {
            return redirect()->route('home');
        }
    })->name('dashboard');

    // Profile Routes (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/events/{event}/tickets/{ticket}/checkout', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/events/{event}/tickets/{ticket}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{order}', [BookingController::class, 'show'])->name('bookings.show');

    // Organizer Request
    Route::post('/organizer/request', [OrganizerRequestController::class, 'store'])->name('organizer.request');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('user.favorites');
    Route::post('/favorites/{event}', [FavoriteController::class, 'store'])->name('user.favorites.store');
    Route::delete('/favorites/{event}', [FavoriteController::class, 'destroy'])->name('user.favorites.destroy');
    Route::post('/favorites/{event}/toggle', [FavoriteController::class, 'toggle'])->name('user.favorites.toggle');
    Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('user.favorites.count');
    Route::delete('/favorites', [FavoriteController::class, 'clear'])->name('user.favorites.clear');

    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
    Route::post('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
    Route::get('/orders/{order}/download-ticket', [UserOrderController::class, 'downloadTicket'])->name('user.orders.download-ticket');
    Route::get('/orders/statistics', [UserOrderController::class, 'statistics'])->name('user.orders.statistics');
});

// ========================================
// ORGANIZER ROUTES
// ========================================

// HAPUS 'approved' dari middleware - hanya gunakan 'organizer'
Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Events Management
    Route::resource('events', OrgEventController::class);

    // Ticket Management
    Route::prefix('events/{event}/tickets')->name('events.tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}', [TicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('destroy');
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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');

    // Events Management
    Route::resource('events', AdminEventController::class);

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

// ========================================
// ORGANIZER STATUS ROUTES
// ========================================

Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/pending', function () {
        $user = auth()->user();
        if ($user->status !== 'pending') {
            return redirect()->route('dashboard');
        }
        return view('organizer.pending');
    })->name('organizer.pending');
    
    Route::get('/organizer/rejected', function () {
        $user = auth()->user();
        if ($user->status !== 'rejected') {
            return redirect()->route('dashboard');
        }
        return view('organizer.rejected');
    })->name('organizer.rejected');
    
    // Cancel organizer request
    Route::post('/organizer/cancel-request', [OrganizerRequestController::class, 'cancel'])
        ->name('organizer.cancel');
});