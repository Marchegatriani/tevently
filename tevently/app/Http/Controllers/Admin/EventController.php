<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Diperlukan untuk storeWithPendingEvent

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
            'image_url' => 'required|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // assign current user as organizer (admin)
        $data['organizer_id'] = $request->user()?->id;

        // Clear any previous event data from session
        $request->session()->forget('pending_event');

        // handle image upload (Store temporary path if any)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events/pending', 'public');
            $data['image_url'] = $imagePath;
        }

        // Store validated data in session instead of creating the event
        $request->session()->put('pending_event', $data);

        // Redirect to the route for creating a ticket for a pending event
        return redirect()->route('admin.tickets.create_for_pending_event')
            ->with('success', 'Detail event disimpan sementara. Sekarang, tambahkan tiket pertama untuk menyelesaikan pembuatan event.');
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
            'image_url' => 'required|image|max:2048',
            'status' => 'required|in:draft,published,cancelled,completed',
        ]);

        // prevent changing organizer accidentally
        unset($data['organizer_id']);
        $event->update($data);

        return redirect()->route('admin.events.index')
             ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        // delete stored image if present
        if ($event->image_url) {
            Storage::disk('public')->delete($event->image_url);
        }

        // Delete tickets first (orders will cascade delete if foreign keys are set, otherwise handle orders explicitly)
        $event->tickets()->delete();
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}