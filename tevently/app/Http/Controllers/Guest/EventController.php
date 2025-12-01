<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function home()
    {
        $featuredEvents = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now())
            ->latest()
            ->take(6)
            ->get();

        return view('guest.home', compact('featuredEvents'));
    }

    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now());

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

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

        $categories = Category::all();

        return view('guest.events.index', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        $event->load(['category', 'organizer', 'tickets']);

        if ($event->status !== 'published') {
            abort(404, 'Event not found');
        }

        return view('guest.events.show', compact('event'));
    }
}