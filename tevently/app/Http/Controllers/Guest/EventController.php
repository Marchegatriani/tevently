<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display homepage with featured events
     */
    public function home()
    {
        // Ambil 6 events terbaru yang published
        $featuredEvents = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now())
            ->latest()
            ->take(6)
            ->get();

        return view('guest.home', compact('featuredEvents'));
    }

    /**
     * Display event catalog/list
     */
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now());

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by title or location
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'date':
                $query->orderBy('event_date', 'asc');
                break;
        }

        $events = $query->paginate(8)->withQueryString();

        // Get all categories for filter
        $categories = Category::all();

        return view('guest.events.index', compact('events', 'categories'));
    }

    /**
     * Display event detail
     */
    public function show(Event $event)
    {
        // Load relationships
        $event->load(['category', 'organizer', 'tickets']);

        // Check if event is published
        if ($event->status !== 'published') {
            abort(404, 'Event not found');
        }

        return view('guest.events.show', compact('event'));
    }
}