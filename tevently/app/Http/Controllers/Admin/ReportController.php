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

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrders', 
            'totalEvents',
            'totalUsers',
            'recentOrders',
            'topEvents'
        ));
    }

    public function sales()
    {
        // Sales report with filters
        $query = Order::with(['user', 'event', 'orderItems.ticket'])
            ->where('status', 'confirmed');

        // Date filters
        if (request('start_date')) {
            $query->whereDate('created_at', '>=', request('start_date'));
        }
        
        if (request('end_date')) {
            $query->whereDate('created_at', '<=', request('end_date'));
        }

        $sales = $query->latest()->paginate(20);

        // Summary
        $totalSales = $sales->total();
        $totalRevenue = $sales->sum('total_amount');

        return view('admin.reports.sales', compact('sales', 'totalSales', 'totalRevenue'));
    }

    public function events()
    {
        $events = Event::withCount(['orders as total_orders'])
            ->withSum(['orders as total_revenue' => function ($query) {
                $query->where('status', 'confirmed');
            }], 'total_amount')
            ->with('organizer')
            ->orderBy('total_revenue', 'desc')
            ->paginate(15);

        return view('admin.reports.events', compact('events'));
    }

    public function users()
    {
        $users = User::withCount(['orders as total_orders'])
            ->withSum(['orders as total_spent' => function ($query) {
                $query->where('status', 'confirmed');
            }], 'total_amount')
            ->having('total_orders', '>', 0)
            ->orderBy('total_spent', 'desc')
            ->paginate(15);

        return view('admin.reports.users', compact('users'));
    }
}