<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display homepage with featured events
     */
    public function home()
    {
        $featuredEvents = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now()->toDateString())
            ->latest()
            ->take(6)
            ->get();

        // Return view berdasarkan auth status
        if (Auth::check()) {
            return view('user.home', compact('featuredEvents'));
        } else {
            return view('guest.home', compact('featuredEvents'));
        }
    }

    /**
     * Display event catalog/list - SESUAI MIGRATION
     */
    public function index(Request $request)
    {
        // Base query dengan eager loading - SESUAI KOLOM MIGRATION
        $events = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now()->toDateString())
            ->when($request->filled('category'), function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->search}%")
                      ->orWhere('location', 'like', "%{$request->search}%")
                      ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->whereDate('event_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->whereDate('event_date', '<=', $request->date_to);
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                return match($request->sort) {
                    'oldest' => $query->oldest(),
                    'title' => $query->orderBy('title', 'asc'),
                    'date' => $query->orderBy('event_date', 'asc'),
                    'location' => $query->orderBy('location', 'asc'),
                    default => $query->latest(),
                };
            }, function ($query) {
                return $query->latest();
            })
            ->paginate(9)
            ->withQueryString();

        // Get all categories
        $categories = Category::all();

        return view('guest.home', compact('events', 'categories'));
    }

    /**
     * Display event detail - SESUAI MIGRATION
     */
    public function show(Event $event)
    {
        // Load relationships - HAPUS KONDISI TICKETS YANG MENYEBABKAN ERROR
        $event->load(['category', 'organizer', 'tickets']);

        // Check if event is published
        if ($event->status !== 'published') {
            abort(404, 'Event not found');
        }

        return view('events.show', compact('event'));
    }

    /**
     * Search events (alias untuk index dengan search)
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Events by category
     */
    public function byCategory(Category $category)
    {
        $events = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->where('event_date', '>=', now()->toDateString())
            ->latest()
            ->paginate(9);

        $categories = Category::all();

        return view('events.index', compact('events', 'categories', 'category'));
    }
}