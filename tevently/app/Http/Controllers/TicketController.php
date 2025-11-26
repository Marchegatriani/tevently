<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Event $event)
    {
        $this->authorizeEvent($event);
        $tickets = $event->tickets()->latest()->get();
        
        return view('tickets.index', compact('event', 'tickets'));
    }

    public function create(Event $event)
    {
        $this->authorizeEvent($event);
        return view('tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

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

        $event->tickets()->create($validated);

        return $this->redirectToIndex($event)
            ->with('success', 'Ticket created successfully!');
    }

    public function edit(Event $event, Ticket $ticket)
    {
        $this->authorizeEventAndTicket($event, $ticket);
        return view('tickets.edit', compact('event', 'ticket'));
    }

    public function update(Request $request, Event $event, Ticket $ticket)
    {
        $this->authorizeEventAndTicket($event, $ticket);

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
            return back()->withInput()->with('error', 'Quantity available cannot be less than sold tickets.');
        }

        $ticket->update($validated);

        return $this->redirectToIndex($event)
            ->with('success', 'Ticket updated successfully!');
    }

    public function destroy(Event $event, Ticket $ticket)
    {
        $this->authorizeEventAndTicket($event, $ticket);

        if ($ticket->orders()->exists()) {
            return back()->with('error', 'Cannot delete ticket with existing orders!');
        }

        $ticket->delete();

        return $this->redirectToIndex($event)
            ->with('success', 'Ticket deleted successfully!');
    }

    public function toggleActive(Event $event, Ticket $ticket)
    {
        $this->authorizeEventAndTicket($event, $ticket);
        $ticket->update(['is_active' => !$ticket->is_active]);

        return back()->with('success', "Ticket " . ($ticket->is_active ? 'activated' : 'deactivated') . "!");
    }

    /**
     * Authorization methods
     */
    private function authorizeEvent(Event $event)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') return true;
        if ($user->role === 'organizer' && $event->organizer_id === $user->id) return true;
        
        abort(403, 'Unauthorized action.');
    }

    private function authorizeEventAndTicket(Event $event, Ticket $ticket)
    {
        $this->authorizeEvent($event);
        if ($ticket->event_id !== $event->id) abort(404);
    }

    private function redirectToIndex(Event $event)
    {
        $user = Auth::user();
        $route = $user->role === 'admin' ? 'admin.events.tickets.index' : 'organizer.events.tickets.index';
        return redirect()->route($route, $event);
    }
}