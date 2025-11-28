<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of favorite events
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
                            ->with(['event' => function($query) {
                                $query->with(['category', 'organizer', 'tickets']);
                            }])
                            ->latest()
                            ->paginate(12);

        return view('user.favorites.index', compact('favorites'));
    }

    /**
     * Add event to favorites
     */
    public function store(Request $request, Event $event)
    {
        // Check if already favorited
        $existingFavorite = Favorite::where('user_id', Auth::id())
                                   ->where('event_id', $event->id)
                                   ->first();

        if ($existingFavorite) {
            return back()->with('error', 'Event already in favorites!');
        }

        // Create new favorite
        Favorite::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'Event added to favorites!');
    }

    /**
     * Remove event from favorites
     */
    public function destroy(Event $event)
    {
        $favorite = Favorite::where('user_id', Auth::id())
                           ->where('event_id', $event->id)
                           ->first();

        if (!$favorite) {
            return back()->with('error', 'Event not found in favorites!');
        }

        $favorite->delete();

        return back()->with('success', 'Event removed from favorites!');
    }

    /**
     * Toggle favorite status
     */
    public function toggle(Request $request, Event $event)
    {
        $favorite = Favorite::where('user_id', Auth::id())
                           ->where('event_id', $event->id)
                           ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Event removed from favorites';
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
            ]);
            $message = 'Event added to favorites';
            $isFavorited = true;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_favorited' => $isFavorited,
                'favorites_count' => Favorite::where('user_id', Auth::id())->count()
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Get favorites count (for AJAX)
     */
    public function count()
    {
        $count = Favorite::where('user_id', Auth::id())->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Clear all favorites
     */
    public function clear()
    {
        Favorite::where('user_id', Auth::id())->delete();

        return back()->with('success', 'All favorites cleared!');
    }
}