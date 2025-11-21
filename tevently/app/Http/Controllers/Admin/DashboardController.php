<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $stats = [
            'total_users' => User::count(),
            'pending_organizers' => User::where('role', 'organizer')
                                       ->where('status', 'pending')
                                       ->count(),
            'total_events' => Event::count(),
        ];

        return view('admin.dashboard', $stats);
    }
}