<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with(['event', 'orderItems.ticket'])
                      ->latest()
                      ->paginate(10);

        $totalOrders = Order::where('user_id', Auth::id())->count();
        $pendingOrders = Order::where('user_id', Auth::id())->where('status', 'pending')->count();
        $confirmedOrders = Order::where('user_id', Auth::id())->where('status', 'confirmed')->count();

        return view('user.orders.index', compact('orders', 'totalOrders', 'pendingOrders', 'confirmedOrders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['event', 'orderItems.ticket', 'user']);

        return view('user.orders.show', compact('order'));
    }

    public function showCancelForm(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($order->status !== 'pending') {
            return redirect()->route('user.orders.show', $order)->with('error', 'Only pending orders can be cancelled.');
        }

        return view('user.orders.cancel', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        foreach ($order->orderItems as $item) {
            $ticket = $item->ticket;
            $ticket->quantity_sold = max(0, $ticket->quantity_sold - $item->quantity);
            $ticket->save();
        }

        return redirect()->route('user.orders.show', $order)->with('success', 'Order cancelled successfully.');
    }

    public function downloadTicket(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed orders can download tickets.');
        }

        return back()->with('success', 'E-ticket download feature coming soon.');
    }

    public function statistics()
    {
        $stats = [
            'total_orders' => Order::where('user_id', Auth::id())->count(),
            'pending_orders' => Order::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'confirmed_orders' => Order::where('user_id', Auth::id())->where('status', 'confirmed')->count(),
            'total_spent' => Order::where('user_id', Auth::id())->where('status', 'confirmed')->sum('total_amount'),
        ];

        return response()->json($stats);
    }
}