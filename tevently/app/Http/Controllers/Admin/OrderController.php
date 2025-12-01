<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Tampilkan list orders dengan pagination
    public function index(Request $request)
    {
        $query = Order::with(['event', 'user', 'orderItems.ticket'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    // Tampilkan single order
    public function show($id)
    {
        $order = Order::with(['event', 'user', 'orderItems.ticket'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function approve($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'pending') {
            return back()->with('info', 'Order tidak dalam status pending.');
        }
        
        // **FIX KRUSIAL:** Menggunakan update(['status' => 'approved']) 
        // Ini memaksa Eloquent untuk menghasilkan query SQL dengan kutipan string yang benar.
        $order->update(['status' => 'confirmed']);

        return back()->with('success', 'Order berhasil dikonfirmasi oleh admin.');
    }

    public function cancel($id)
    {
        $order = Order::with('orderItems.ticket')->findOrFail($id);
        
        if ($order->status === 'cancelled') {
            return back()->with('info', 'Order sudah dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            // Kembalikan stok untuk setiap ticket dalam order
            foreach ($order->orderItems as $orderItem) {
                if ($orderItem->ticket) {
                    $ticket = $orderItem->ticket;
                    $ticket->quantity_sold = max(0, $ticket->quantity_sold - $orderItem->quantity);
                    $ticket->save();
                }
            }
            
            // Menggunakan update(['status' => 'cancelled'])
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Order berhasil dibatalkan oleh admin.');
    }
}