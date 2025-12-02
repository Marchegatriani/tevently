<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $organizer = $request->user();

        $query = Event::where('organizer_id', $organizer->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Event::where('organizer_id', $organizer->id)->count(),
            'published' => Event::where('organizer_id', $organizer->id)->where('status', 'published')->count(),
            'draft' => Event::where('organizer_id', $organizer->id)->where('status', 'draft')->count(),
            'cancelled' => Event::where('organizer_id', $organizer->id)->where('status', 'cancelled')->count(),
        ];

        return view('organizer.events.index', compact('events', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $startDateTime = $validated['event_date'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['event_date'] . ' ' . $validated['end_time'];

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

        return redirect()
            ->route('organizer.tickets.create', $event)
            ->with('success', 'Event created successfully! Now add your tickets.');
    }

    public function show(Request $request, Event $event)
    {
        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'Unauthorized access.');
        }

        $event->load(['category', 'tickets']);

        return view('organizer.events.show', compact('event'));
    }

    public function edit(Request $request, Event $event)
{
    if ($event->organizer_id !== $request->user()->id) {
        abort(403, 'Unauthorized access.');
    }

    $categories = Category::all();
    
    $event->load('tickets');
    
    return view('organizer.events.edit', compact('event', 'categories'));
}

    public function update(Request $request, Event $event)
    {
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:draft,published,cancelled,completed',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

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
            'image' => $validated['image'] ?? $event->image,
            'status' => $validated['status'],
        ]);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Request $request, Event $event)
    {
        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}