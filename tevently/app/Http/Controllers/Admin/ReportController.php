<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalRevenue = Order::where('status', 'confirmed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalEvents = Event::count();
        $totalUsers = User::count();

        // Recent orders
        $recentOrders = Order::with(['user', 'event'])
            ->where('status', 'confirmed')
            ->latest()
            ->take(5)
            ->get();

        // Top events by revenue
        $topEvents = Event::withCount(['orders as total_orders'])
            ->withSum(['orders as total_revenue' => function ($query) {
                $query->where('status', 'confirmed');
            }], 'total_amount')
            ->having('total_orders', '>', 0)
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        return view('admin.reports', compact(
            'totalRevenue',
            'totalOrders', 
            'totalEvents',
            'totalUsers',
            'recentOrders',
            'topEvents'
        ));
    }
}