<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $organizer = $request->user();
        
        $events = $organizer->events()->latest()->get();
        
        $stats = [
            'total_events' => $organizer->events()->count(),
            'published_events' => $organizer->events()->where('status', 'published')->count(),
            'draft_events' => $organizer->events()->where('status', 'draft')->count(),
        ];

        return view('organizer.dashboard', compact('events', 'stats'));
    }
}