<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organizerId = Auth::id();

        // PERBAIKAN: Ganti 'ticket' dengan 'orderItems.ticket'
        $orders = Order::with(['event', 'orderItems.ticket', 'user'])
            ->whereHas('event', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->latest()
            ->paginate(15);

        return view('organizer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // PERBAIKAN: Ganti 'ticket' dengan 'orderItems.ticket'
        $order = Order::with(['event', 'orderItems.ticket', 'user'])->findOrFail($id);

        if ($order->event->organizer_id !== Auth::id()) {
            abort(404);
        }

        return view('organizer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Approve / confirm order
    public function approve($id)
    {
        // PERBAIKAN: Ganti 'ticket' dengan 'orderItems.ticket'
        $order = Order::with(['event', 'orderItems.ticket'])->findOrFail($id);

        if ($order->event->organizer_id !== Auth::id()) {
            abort(404);
        }

        if ($order->status !== 'pending') {
            return back()->with('info', 'Order tidak dalam status pending.');
        }

        $order->status = 'confirmed';
        $order->save();

        return back()->with('success', 'Order berhasil dikonfirmasi.');
    }

    // Cancel order and release tickets (decrement quantity_sold)
    public function cancel($id)
    {
        // PERBAIKAN: Ganti 'ticket' dengan 'orderItems.ticket'
        $order = Order::with(['event', 'orderItems.ticket'])->findOrFail($id);

        if ($order->event->organizer_id !== Auth::id()) {
            abort(404);
        }

        if ($order->status === 'cancelled') {
            return back()->with('info', 'Order sudah dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            // PERBAIKAN: Loop melalui orderItems untuk mengembalikan tiket
            foreach ($order->orderItems as $item) {
                if ($item->ticket) {
                    $item->ticket->quantity_sold = max(0, $item->ticket->quantity_sold - $item->quantity);
                    $item->ticket->save();
                }
            }

            $order->status = 'cancelled';
            $order->save();
        });

        return back()->with('success', 'Order berhasil dibatalkan.');
    }
}