<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Event $event)
    {
        
        $tickets = $event->tickets()->latest()->get();
        
        return view('organizer.tickets.index', compact('event', 'tickets'));
    }

    public function create(Event $event)
    {
        return view('organizer.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'required|date',
            'sales_end' => 'required|date|after_or_equal:sales_start|before_or_equal:'.$event->event_date->format('Y-m-d'),
        ]);

        $event->tickets()->create($validated);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Ticket created successfully!');
    }

    public function edit(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        return view('organizer.tickets.edit', compact('event', 'ticket'));
    }

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
            'sales_end' => 'required|date|after_or_equal:sales_start|before_or_equal:'.$event->event_date->format('Y-m-d'),
            'is_active' => 'boolean',
        ]);

        if ($validated['quantity_available'] < $ticket->quantity_sold) {
            return back()
                ->withInput()
                ->with('error', 'Quantity available cannot be less than sold tickets.');
        }

        $ticket->update($validated);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Ticket updated successfully!');
    }

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
            ->route('organizer.events.show', $event)
            ->with('success', 'Ticket deleted successfully!');
    }

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