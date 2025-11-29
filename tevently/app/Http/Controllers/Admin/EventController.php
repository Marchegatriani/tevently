<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['organizer', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'location' => 'required|string|max:255',
        'event_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'max_attendees' => 'required|integer|min:1',
        'image' => 'nullable|image|max:2048',
        'status' => 'required|in:draft,published',
    ]);

    // assign current user as organizer (admin) if not provided
    $data['organizer_id'] = $data['organizer_id'] ?? $request->user()?->id;

    // handle image upload
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('events', 'public');
    }

    // Create event
    $event = Event::create($data);

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

    return redirect()->route('admin.events.index')
        ->with('success', 'Event created successfully!');
}

    public function show(Event $event)
    {
        $event->load(['organizer', 'category', 'tickets']);
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'location' => 'required|string|max:255',
        'event_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'max_attendees' => 'required|integer|min:1',
        'image' => 'nullable|image|max:2048',
        'status' => 'required|in:draft,published,cancelled,completed',
    ]);

    // prevent changing organizer accidentally
    unset($data['organizer_id']);

    // Handle image replacement
    if ($request->hasFile('image')) {
        // delete old image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $data['image'] = $request->file('image')->store('events', 'public');
    }

    $event->update($data);

    // ✅ OPSIONAL: Tambahkan logic untuk update tickets jika diperlukan
    // (Untuk sekarang fokus ke create dulu)

    return redirect()->route('admin.events.index')
         ->with('success', 'Event updated successfully!');
}

    public function destroy(Event $event)
{
    // Check if event has tickets or orders
    if ($event->tickets()->exists()) {
        // ✅ Hapus semua tickets terlebih dahulu
        $event->tickets()->delete();
    }

    // delete stored image if present
    if ($event->image) {
        Storage::disk('public')->delete($event->image);
    }

    $event->delete();

    return redirect()->route('admin.events.index')
        ->with('success', 'Event deleted successfully!');
}
}