<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizerRequestController extends Controller
{
    /**
     * Handle organizer request
     */
    public function store(Request $request)
    {
        $user = $request->user(); // Pakai $request->user() bukan auth()->user()

        // Cek apakah user sudah organizer
        if ($user->role === 'organizer') {
            // Jika rejected, bisa re-apply
            if ($user->status === 'rejected') {
                $user->update(['status' => 'pending']);
                return redirect()->route('dashboard')->with('success', 'Your organizer request has been resubmitted!');
            }
            
            return redirect()->route('dashboard')->with('info', 'You already have an organizer request pending.');
        }

        // Upgrade user ke organizer dengan status pending
        $user->update([
            'role' => 'organizer',
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Your request to become an organizer has been submitted!');
    }
}