<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display tickets for specific event
     */
    public function index(Event $event)
    {
        // Make sure organizer owns this event menggunakan Eloquent
        $this->authorizeEvent($event);

        $tickets = $event->tickets()
            ->withCount(['orders as total_orders'])
            ->latest()
            ->get();

        return view('organizer.tickets.index', compact('event', 'tickets'));
    }

    /**
     * Show form to create new ticket
     */
    public function create(Event $event)
    {
        // Make sure organizer owns this event
        $this->authorizeEvent($event);

        return view('organizer.tickets.create', compact('event'));
    }

    /**
     * Store new ticket
     */
    public function store(Request $request, Event $event)
    {
        // Make sure organizer owns this event
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'nullable|date',
            'sales_end' => 'nullable|date|after_or_equal:sales_start',
            'is_active' => 'boolean',
        ]);

        // Create ticket menggunakan Eloquent relationship
        $event->tickets()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'quota' => $validated['quota'],
            'quota_remaining' => $validated['quota'], // Set quota_remaining sama dengan quota
            'max_per_order' => $validated['max_per_order'],
            'sales_start' => $validated['sales_start'],
            'sales_end' => $validated['sales_end'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('organizer.events.tickets.index', $event)
            ->with('success', 'Ticket berhasil dibuat!');
    }

    /**
     * Show form to edit ticket
     */
    public function edit(Event $event, Ticket $ticket)
    {
        // Make sure organizer owns this event and ticket belongs to event
        $this->authorizeEventAndTicket($event, $ticket);

        return view('organizer.tickets.edit', compact('event', 'ticket'));
    }

    /**
     * Update ticket
     */
    public function update(Request $request, Event $event, Ticket $ticket)
    {
        // Make sure organizer owns this event and ticket belongs to event
        $this->authorizeEventAndTicket($event, $ticket);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'nullable|date',
            'sales_end' => 'nullable|date|after_or_equal:sales_start',
            'is_active' => 'boolean',
        ]);

        // Calculate new quota_remaining
        $quotaDiff = $validated['quota'] - $ticket->quota;
        $newQuotaRemaining = max(0, $ticket->quota_remaining + $quotaDiff);

        // Update menggunakan Eloquent
        $ticket->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'quota' => $validated['quota'],
            'quota_remaining' => $newQuotaRemaining,
            'max_per_order' => $validated['max_per_order'],
            'sales_start' => $validated['sales_start'],
            'sales_end' => $validated['sales_end'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('organizer.events.tickets.index', $event)
            ->with('success', 'Ticket berhasil diperbarui!');
    }

    /**
     * Delete ticket
     */
    public function destroy(Event $event, Ticket $ticket)
    {
        // Make sure organizer owns this event and ticket belongs to event
        $this->authorizeEventAndTicket($event, $ticket);

        // Check if ticket has orders menggunakan Eloquent
        if ($ticket->orders()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus ticket yang sudah memiliki pesanan!');
        }

        // Delete menggunakan Eloquent
        $ticket->delete();

        return redirect()
            ->route('organizer.events.tickets.index', $event)
            ->with('success', 'Ticket berhasil dihapus!');
    }

    /**
     * Toggle ticket active status
     */
    public function toggleActive(Event $event, Ticket $ticket)
    {
        // Make sure organizer owns this event and ticket belongs to event
        $this->authorizeEventAndTicket($event, $ticket);

        // Toggle status menggunakan Eloquent
        $ticket->update([
            'is_active' => !$ticket->is_active
        ]);

        $status = $ticket->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Ticket berhasil {$status}!");
    }


    /**
     * Authorization method untuk event
     */
    private function authorizeEvent(Event $event)
    {
        // Lebih simple dengan policy atau langsung check
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Authorization method untuk event dan ticket
     */
    private function authorizeEventAndTicket(Event $event, Ticket $ticket)
    {
        $this->authorizeEvent($event);
        
        // Pastikan ticket belongs to event
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }
    }
}