<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets for an event (ADMIN)
     */
    public function index(Event $event)
    {
        $tickets = $event->tickets()->latest()->get();
        return view('admin.tickets.index', compact('event', 'tickets'));
    }

    /**
     * Show the form for creating a new ticket for an EXISTING event (ADMIN)
     */
    public function create(Event $event)
    {
        return view('admin.tickets.create', compact('event'));
    }

    /**
     * Show the form for creating the first ticket for a new, PENDING event.
     */
    public function createForPendingEvent(Request $request)
    {
        if (!$request->session()->has('pending_event')) {
            return redirect()->route('admin.events.create')->with('error', 'Silakan isi detail event terlebih dahulu.');
        }

        // Create a temporary Event object for the view, without saving it
        $eventData = $request->session()->get('pending_event');
        $event = new Event($eventData);
        // We set exists to false so the form knows it's a new event
        $event->exists = false; 

        return view('admin.tickets.create', compact('event'));
    }

    /**
     * Store a newly created ticket to an EXISTING event (ADMIN)
     */
    public function store(Request $request, Event $event)
    {
        // 1. Ambil semua input dan bungkus dalam format array yang diharapkan
        $ticketData = $request->except('_token');
        $request->merge(['tickets' => [$ticketData]]);

        // 2. Validasi data yang sudah di-merge
        $validatedData = $request->validate([
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.description' => 'nullable|string',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quantity_available' => 'required|integer|min:1',
            'tickets.*.max_per_order' => 'required|integer|min:1',
            'tickets.*.sales_start' => 'required|date',
            'tickets.*.sales_end' => 'required|date|after_or_equal:tickets.*.sales_start|before_or_equal:'.$event->event_date->format('Y-m-d H:i:s'),
        ], [
             'tickets.*.sales_end.before_or_equal' => 'Tanggal penjualan tiket tidak boleh melebihi tanggal acara dimulai.',
        ]);
        $tickets = $validatedData['tickets'];
        $event->tickets()->createMany($tickets);

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', 'Tiket berhasil dibuat!');
    }

    /**
     * Store the first ticket and the pending event from session (ADMIN).
     */
    public function storeWithPendingEvent(Request $request)
    {
        if (!$request->session()->has('pending_event')) {
            return redirect()->route('admin.events.create')->with('error', 'Sesi event telah berakhir. Silakan ulangi.');
        }

        $eventData = $request->session()->get('pending_event');
        $eventDate = $eventData['event_date'];

        // 1. Ambil semua input dan bungkus dalam format array yang diharapkan
        $ticketData = $request->except('_token');
        $request->merge(['tickets' => [$ticketData]]);

        // 2. Validasi data yang sudah di-merge
        $validatedData = $request->validate([
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.description' => 'nullable|string',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quantity_available' => 'required|integer|min:1',
            'tickets.*.max_per_order' => 'required|integer|min:1',
            'tickets.*.sales_start' => 'required|date',
            'tickets.*.sales_end' => 'required|date|after_or_equal:tickets.*.sales_start|before_or_equal:'.$eventDate,
        ], [
             'tickets.*.sales_end.before_or_equal' => 'Tanggal penjualan tiket tidak boleh melebihi tanggal acara.',
        ]);

        $tickets = $validatedData['tickets'];

        $event = DB::transaction(function () use ($eventData, $tickets) {
            // 1. Create Event
            $event = Event::create($eventData);
            
            // 2. Create Tickets
            $event->tickets()->createMany($tickets);
            return $event;
        });

        $request->session()->forget('pending_event');

        return redirect()->route('admin.events.show', $event)->with('success', 'Event dan tiket berhasil dibuat!');
    }

    /**
     * Show the form for editing a ticket (ADMIN)
     */
    public function edit(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        return view('admin.tickets.edit', compact('event', 'ticket'));
    }

    /**
     * Update the specified ticket (ADMIN)
     */
    public function update(Request $request, Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'required|date',
            'sales_end' => 'required|date|after_or_equal:sales_start|before_or_equal:'.$event->event_date->format('Y-m-d H:i:s'),
            'is_active' => 'boolean',
        ], [
             'sales_end.before_or_equal' => 'Tanggal penjualan berakhir tidak boleh melebihi tanggal acara dimulai.',
        ]);

        if ($validated['quantity_available'] < $ticket->quantity_sold) {
            return back()
                ->withInput()
                ->with('error', 'Quantity available cannot be less than sold tickets.');
        }

        $ticket->update($validated);

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove the specified ticket (ADMIN)
     */
    public function destroy(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        if ($ticket->orders()->exists()) {
            return back()->with('error', 'Cannot delete ticket with existing orders!');
        }

        $ticket->delete();

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', 'Ticket deleted successfully!');
    }

    /**
     * Toggle ticket active status (ADMIN)
     */
    public function toggleActive(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $ticket->update(['is_active' => !$ticket->is_active]);

        $status = $ticket->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Ticket {$status} successfully!");
    }
}