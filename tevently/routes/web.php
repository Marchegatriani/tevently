<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizerRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guest\EventController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Organizer\OrgEventController;
use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Organizer\OrderController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Route;

// ========================================
// GUEST ROUTES (Public - Tanpa Login)
// ========================================

Route::get('/', [EventController::class, 'home'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
// Event Catalog & Detail
// Event Catalog & Detail (akan dibuat nanti)
// Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
// Route::get('/events/{event}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');


// ========================================
// AUTH ROUTES (Login/Register)
// ========================================
require __DIR__.'/auth.php';


// ========================================
// USER ROUTES (Authenticated Users)
// ========================================

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::post('/organizer/request', [OrganizerRequestController::class, 'store'])
    ->name('organizer.request')
    ->middleware('auth');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Orders (Booking) - akan dibuat nanti
    // Route::resource('orders', App\Http\Controllers\User\OrderController::class);
    
    // Favorites - akan dibuat nanti
    Route::get('/favorites', function () {
        return view('user.favorites');
    })->name('favorites');
    // Route::post('/favorites/{event}', [App\Http\Controllers\User\FavoriteController::class, 'toggle'])->name('favorites.toggle');
    // Route::get('/favorites', [App\Http\Controllers\User\FavoriteController::class, 'index'])->name('favorites.index');
});


// ========================================
// ORGANIZER ROUTES
// ========================================

// Organizer Dashboard & Features (harus approved)
Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    
    // Dashboard (gunakan controller)
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events Management (Resource Controller)
    Route::resource('events', OrgEventController::class);


    // Events Management - akan dibuat nanti
    // Route::resource('events', App\Http\Controllers\Organizer\EventController::class);
    
    // Tickets Management - akan dibuat nanti
    // Route::resource('events.tickets', App\Http\Controllers\Organizer\TicketController::class);
    // Ticket Management Routes
    Route::prefix('events/{event}/tickets')->name('events.tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('create', [TicketController::class, 'create'])->name('create');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
        Route::put('{ticket}', [TicketController::class, 'update'])->name('update');
        Route::delete('{ticket}', [TicketController::class, 'destroy'])->name('destroy');
        Route::post('{ticket}/toggle', [TicketController::class, 'toggleActive'])->name('toggle');
    });
    // Orders Management - akan dibuat nanti
    // Orders routes untuk organizer (langsung di bawah prefix('organizer') utama)
    // Tambahkan routes orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/approve', [OrderController::class, 'approve'])->name('approve');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });
    // Route::get('orders', [App\Http\Controllers\Organizer\OrderController::class, 'index'])->name('orders.index');
    // Route::patch('orders/{order}/confirm', [App\Http\Controllers\Organizer\OrderController::class, 'confirm'])->name('orders.confirm');
    // Route::patch('orders/{order}/cancel', [App\Http\Controllers\Organizer\OrderController::class, 'cancel'])->name('orders.cancel');
});


// ========================================
// ADMIN ROUTES
// ========================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard (gunakan view controller nanti; saat ini tetap pakai view)
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Users management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::patch('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
    // Users Management - akan dibuat nanti
    // Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    // Route::patch('users/{user}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
    // Route::patch('users/{user}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('users.reject');
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        //Route::post('/{order}/approve', [OrderController::class, 'approve'])->name('approve');
        //Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // Events Management - akan dibuat nanti
    // Route::resource('events', App\Http\Controllers\Admin\EventController::class);
    Route::resource('events', AdminEventController::class);
    // Reports - akan dibuat nanti
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/sales', [AdminReportController::class, 'sales'])->name('sales');
        Route::get('/events', [AdminReportController::class, 'events'])->name('events');
        Route::get('/users', [AdminReportController::class, 'users'])->name('users');
    });
    // Route::get('reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});