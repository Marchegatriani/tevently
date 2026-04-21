<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function create(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $remaining = max(0, $ticket->quantity_available - $ticket->quantity_sold);
        if (! $ticket->is_active || $remaining <= 0) {
            return redirect()->back()->with('error', 'Tiket tidak tersedia untuk pemesanan.');
        }

        $max_per_order = $ticket->max_per_order;

        return view('user.orders.create', compact('event', 'ticket', 'remaining', 'max_per_order'));
    }

    public function store(Request $request, Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $remaining = max(0, $ticket->quantity_available - $ticket->quantity_sold);
        $maxAllowed = min($remaining, $ticket->max_per_order);

        $validated = $request->validate([
            'quantity' => ['required','integer','min:1','max:'.$maxAllowed],
        ]);
        
        $order = null;
        
        try {
            DB::transaction(function () use ($ticket, $validated, $event, &$order) {
                $ticket->refresh();
                $available = max(0, $ticket->quantity_available - $ticket->quantity_sold);
                if ($validated['quantity'] > $available) {
                    throw new \Exception('Jumlah tiket yang tersedia tidak cukup.');
                }

                $ticket->quantity_sold += $validated['quantity'];
                $ticket->save();

                $order = Order::create([
                    'user_id'      => Auth::id(),
                    'event_id'     => $event->id,
                    'total_amount' => $ticket->price * $validated['quantity'],
                    'status'       => 'pending',
                ]);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'ticket_id'  => $ticket->id,
                    'quantity'   => $validated['quantity'],
                    'unit_price' => $ticket->price,
                ]);
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        if (! empty($order)) {
            return redirect()->route('user.orders.show', $order)->with('success', 'Pemesanan berhasil dibuat. Tunggu konfirmasi pembayaran.');
        }

        return redirect()->route('user.orders.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
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