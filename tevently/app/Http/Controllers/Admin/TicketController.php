<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets for an event
     */
    public function index(Event $event)
    {
        $tickets = $event->tickets()->latest()->get();
        
        return view('admin.tickets.index', compact('event', 'tickets'));
    }

    /**
     * Show the form for creating a new ticket
     */
    public function create(Event $event)
    {
        return view('admin.tickets.create', compact('event'));
    }

    /**
     * Store a newly created ticket
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'required|date',
            'sales_end' => 'required|date|after_or_equal:sales_start',
        ]);

        $event->tickets()->create($validated);

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', 'Ticket created successfully!');
    }

    /**
     * Show the form for editing a ticket
     */
    public function edit(Event $event, Ticket $ticket)
    {
        // Verify ticket belongs to event
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        return view('admin.tickets.edit', compact('event', 'ticket'));
    }

    /**
     * Update the specified ticket
     */
    public function update(Request $request, Event $event, Ticket $ticket)
    {
        // Verify ticket belongs to event
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
            'sales_end' => 'required|date|after_or_equal:sales_start',
            'is_active' => 'boolean',
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
     * Remove the specified ticket
     */
    public function destroy(Event $event, Ticket $ticket)
    {
        // Verify ticket belongs to event
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
     * Toggle ticket active status
     */
    public function toggleActive(Event $event, Ticket $ticket)
    {
        // Verify ticket belongs to event
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $ticket->update(['is_active' => !$ticket->is_active]);

        $status = $ticket->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Ticket {$status} successfully!");
    }
}