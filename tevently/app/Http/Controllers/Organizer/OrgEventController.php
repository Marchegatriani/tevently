<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrgEventController extends Controller
{
    /**
     * Display a listing of events (organizer's events only)
     */
    public function index(Request $request)
    {
        $organizer = $request->user();

        $query = Event::where('organizer_id', $organizer->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(10)->withQueryString();

        // Statistics
        $stats = [
            'total' => Event::where('organizer_id', $organizer->id)->count(),
            'published' => Event::where('organizer_id', $organizer->id)->where('status', 'published')->count(),
            'draft' => Event::where('organizer_id', $organizer->id)->where('status', 'draft')->count(),
            'cancelled' => Event::where('organizer_id', $organizer->id)->where('status', 'cancelled')->count(),
        ];

        // PERBAIKAN: Langsung ke organizer/events.blade.php
        return view('organizer.events.index', compact('events', 'stats'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        $categories = Category::all();
        // PERBAIKAN: Langsung ke organizer/events-create.blade.php atau events/create.blade.php
        return view('organizer.events.create', compact('categories'));
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'category_id' => 'required|exists:categories,id',
            'max_attendees' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        // Combine date and time
        $startDateTime = $validated['event_date'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['event_date'] . ' ' . $validated['end_time'];

        // Create event
        $event = Event::create([
            'organizer_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'max_attendees' => $validated['max_attendees'],
            'image_url' => $imagePath,
            'status' => $validated['status'],
        ]);

        // Create tickets jika ada
        if ($request->has('tickets')) {
            foreach ($request->tickets as $ticketData) {
                $event->tickets()->create([
                    'name' => $ticketData['name'],
                    'description' => $ticketData['description'] ?? null,
                    'price' => $ticketData['price'],
                    'quantity_available' => $ticketData['quantity_available'],
                    'max_per_order' => $ticketData['max_per_order'] ?? 5,
                    'is_active' => true,
                    'sales_start' => now(),
                    'sales_end' => now()->addMonths(1),
                ]);
            }
        }

        // PERBAIKAN: Redirect ke route yang benar
        return redirect()->route('organizer.events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event
     */
    public function show(Request $request, Event $event)
    {
        // Authorization: only owner can view
        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'Unauthorized access.');
        }

        $event->load(['category', 'tickets']);

        // PERBAIKAN: Langsung ke organizer/events-show.blade.php atau events/show.blade.php
        return view('organizer.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event
     */
    public function edit(Request $request, Event $event)
    {
        // Authorization: only owner can edit
        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Category::all();
        // PERBAIKAN: Langsung ke organizer/events-edit.blade.php atau events/edit.blade.php
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, Event $event)
    {
        // Authorization: only owner can update
        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'category_id' => 'required|exists:categories,id',
            'max_attendees' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:draft,published,cancelled,completed',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image_url) {
                Storage::disk('public')->delete($event->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('events', 'public');
        }

        // Combine date and time
        $startDateTime = $validated['event_date'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['event_date'] . ' ' . $validated['end_time'];

        $event->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'max_attendees' => $validated['max_attendees'],
            'image_url' => $validated['image_url'] ?? $event->image_url,
            'status' => $validated['status'],
        ]);

        // PERBAIKAN: Redirect ke route yang benar
        return redirect()->route('organizer.events.index')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event
     */
    public function destroy(Request $request, Event $event)
    {
        // Authorization: only owner can delete
        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'Unauthorized access.');
        }

        // Delete image if exists
        if ($event->image_url) {
            Storage::disk('public')->delete($event->image_url);
        }

        $event->delete();

        // PERBAIKAN: Redirect ke route yang benar
        return redirect()->route('organizer.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}