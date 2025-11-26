<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // list bookings (uses Order model if available)
    public function index()
    {
        $bookings = collect();
        if (class_exists(\App\Models\Order::class)) {
            $bookings = \App\Models\Order::where('user_id', Auth::id())->latest()->paginate(10);
        }

        return view('user.bookings.index', compact('bookings'));
    }

    // show checkout form for specific event & ticket
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

    // store booking (safe with DB transaction)
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
            DB::transaction(function () use ($ticket, $validated, &$order) {
                // refresh & re-check
                $ticket->refresh();
                $available = max(0, $ticket->quantity_available - $ticket->quantity_sold);
                if ($validated['quantity'] > $available) {
                    throw new \Exception('Not enough tickets available.');
                }

                // update sold count
                $ticket->quantity_sold += $validated['quantity'];
                $ticket->save();

                // create Order if model exists
                if (class_exists(\App\Models\Order::class)) {
                    $order = \App\Models\Order::create([
                        'user_id'      => Auth::id(),
                        'event_id'     => $ticket->event_id,
                        'ticket_id'    => $ticket->id,
                        // keep quantity for backward compatibility, and set total_tickets for DB schema expecting this column
                        'quantity'     => $validated['quantity'],
                        'total_tickets'=> $validated['quantity'],
                        // DB expects `total_amount`
                        'total_amount' => $ticket->price * $validated['quantity'],
                        'status'       => 'pending',
                    ]);
                } else {
                    $order = null;
                }
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        if (! empty($order)) {
            return redirect()->route('bookings.show', $order)->with('success', 'Booking created successfully.');
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    // show single booking/order if model exists
    public function show($id)
    {
        if (! class_exists(\App\Models\Order::class)) {
            abort(404);
        }

        $order = \App\Models\Order::with(['ticket','event'])->where('user_id', Auth::id())->findOrFail($id);

        return view('user.bookings.show', compact('order'));
    }
}
