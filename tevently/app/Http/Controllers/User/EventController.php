<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function home()
    {
        $featuredEvents = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now()->toDateString())
            ->latest()
            ->take(6)
            ->get();

        return view('user.home', compact('featuredEvents'));
    }


    public function index(Request $request)
    {
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

        $categories = Category::all();

        return view('user.events.index', compact('events', 'categories'));
    }


    public function show(Event $event) {
        $event->load(['category', 'organizer', 'tickets' => function($query) {
            $query->where('is_active', true)
                ->where('sales_start', '<=', now())
                ->where('sales_end', '>=', now());
        }]);

        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->favoriteEvents()->where('event_id', $event->id)->exists();
        }

        $relatedEvents = Event::where('status', 'published')
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('event_date', '>=', now())
            ->with(['category', 'organizer'])
            ->latest()
            ->take(4)
            ->get();

        return view('user.events.show', compact('event', 'relatedEvents', 'isFavorited'));
    }

    /**
     * Search events
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

        return view('user.events.index', compact('events', 'categories', 'category'));
    }
}