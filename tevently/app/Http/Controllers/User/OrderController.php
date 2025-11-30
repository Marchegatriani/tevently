<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of user orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with(['event', 'orderItems.ticket'])
                      ->latest()
                      ->paginate(10);

        // Statistics
        $totalOrders = Order::where('user_id', Auth::id())->count();
        $pendingOrders = Order::where('user_id', Auth::id())->where('status', 'pending')->count();
        $confirmedOrders = Order::where('user_id', Auth::id())->where('status', 'confirmed')->count();

        return view('user.orders.index', compact('orders', 'totalOrders', 'pendingOrders', 'confirmedOrders'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        // Authorization - user hanya bisa lihat order sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['event', 'orderItems.ticket', 'user']);

        return view('user.orders.show', compact('order'));
    }

    /**
     * Show the form for cancelling an order.
     */
    public function showCancelForm(Order $order)
    {
        // Authorization - user hanya bisa lihat order sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($order->status !== 'pending') {
            return redirect()->route('user.orders.show', $order)->with('error', 'Only pending orders can be cancelled.');
        }

        return view('user.orders.cancel', compact('order'));
    }
    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        // Authorization
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Hanya order pending yang bisa dicancel
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        // Kembalikan kuota ticket
        foreach ($order->orderItems as $item) {
            $ticket = $item->ticket;
            $ticket->quantity_sold = max(0, $ticket->quantity_sold - $item->quantity);
            $ticket->save();
        }

        return redirect()->route('user.orders.show', $order)->with('success', 'Order cancelled successfully.');
    }

    /**
     * Download e-ticket (jika order confirmed)
     */
    public function downloadTicket(Order $order)
    {
        // Authorization
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Hanya order confirmed yang bisa download ticket
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed orders can download tickets.');
        }

        // Logic untuk generate PDF e-ticket
        // return $this->generateETicket($order);

        return back()->with('success', 'E-ticket download feature coming soon.');
    }

    /**
     * Get order statistics (for dashboard)
     */
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