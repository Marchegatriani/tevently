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
            ->where('event_date', '>=', now())
            ->latest()
            ->take(6)
            ->get();

        // Return view berdasarkan auth status menggunakan Eloquent relationship check
        if (Auth::check()) {
            return view('user.home', compact('featuredEvents'));
        } else {
            return view('guest.home', compact('featuredEvents'));
        }
    }

    /**
     * Display event catalog/list
     */
    public function index(Request $request)
    {
        // Base query dengan eager loading
        $events = Event::with(['category', 'organizer'])
            ->where('status', 'published')
            ->where('event_date', '>=', now())
            ->when($request->filled('category'), function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->search}%")
                      ->orWhere('location', 'like', "%{$request->search}%");
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
                    default => $query->latest(),
                };
            }, function ($query) {
                return $query->latest();
            })
            ->paginate(9)
            ->withQueryString();

        // Get all categories menggunakan Eloquent
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display event detail
     */
    public function show(Event $event)
    {
        // Load relationships menggunakan Eloquent
        $event->load(['category', 'organizer', 'tickets' => function ($query) {
            $query->where('is_active', true)
                  ->where('quota_remaining', '>', 0)
                  ->where(function ($q) {
                      $q->whereNull('sales_start')
                        ->orWhere('sales_start', '<=', now());
                  })
                  ->where(function ($q) {
                      $q->whereNull('sales_end')
                        ->orWhere('sales_end', '>=', now());
                  });
        }]);

        // Check if event is published menggunakan Eloquent scope
        if (!$event->isPublished()) {
            abort(404, 'Event not found');
        }

        return view('events.show', compact('event'));
    }
}