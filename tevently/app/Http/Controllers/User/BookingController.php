<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = collect();
        if (class_exists(Order::class)) {
            $bookings = Order::with(['event', 'orderItems.ticket'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $remaining = max(0, $ticket->quantity_available - $ticket->quantity_sold);
        if (! $ticket->is_active || $remaining <= 0) {
            return redirect()->back()->with('error', 'Ticket not available for booking.');
        }

        $max_per_order = $ticket->max_per_order;

        return view('user.bookings.create', compact('event', 'ticket', 'remaining', 'max_per_order'));
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

        try {
            DB::transaction(function () use ($ticket, $validated, $event, &$order) {
                $ticket->refresh();
                $available = max(0, $ticket->quantity_available - $ticket->quantity_sold);
                if ($validated['quantity'] > $available) {
                    throw new \Exception('Not enough tickets available.');
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
            return redirect()->route('bookings.show', $order)->with('success', 'Booking created successfully.');
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show($id)
    {
        if (! class_exists(Order::class)) {
            abort(404);
        }

        $order = Order::with(['event', 'orderItems.ticket', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.bookings.show', compact('order'));
    }
}