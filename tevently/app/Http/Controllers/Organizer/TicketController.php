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

        // Ambil tiket tanpa withCount karena tabel orders mungkin tidak memiliki foreign key ticket_id
        $tickets = $event->tickets()
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
            'quantity_available' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'required|date',
            'sales_end' => 'required|date|after_or_equal:sales_start',
            'is_active' => 'boolean',
        ]);

        // Create ticket menggunakan Eloquent relationship (sesuai migration)
        $event->tickets()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'quantity_available' => $validated['quantity_available'],
            // quantity_sold default 0 (migration default)
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
            'quantity_available' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|min:1',
            'sales_start' => 'required|date',
            'sales_end' => 'required|date|after_or_equal:sales_start',
            'is_active' => 'boolean',
        ]);

        // Ensure we don't set availability below already sold quantity
        if ($validated['quantity_available'] < $ticket->quantity_sold) {
            return back()->withInput()->with('error', 'Quantity available cannot be less than already sold tickets.');
        }

        // Update menggunakan Eloquent sesuai migration
        $ticket->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'quantity_available' => $validated['quantity_available'],
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