<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get featured events (published events)
        $featuredEvents = Event::where('status', 'published')
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        // Get user stats
        $user = Auth::user();
        return view('user.index', compact('featuredEvents'));
    }
}