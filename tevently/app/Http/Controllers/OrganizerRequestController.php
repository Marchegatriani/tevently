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
        $user = $request->user();

        // Cek apakah user sudah punya request pending
        if ($user->status === 'pending') {
            return redirect()->route('dashboard')->with('info', 'You already have an organizer request pending.');
        }

        // Cek apakah user sudah jadi organizer
        if ($user->role === 'organizer') {
            return redirect()->route('dashboard')->with('info', 'You are already an organizer.');
        }

        // Set status jadi pending (role masih 'user')
        $user->update([
            'status' => 'pending', // ← Role TIDAK BERUBAH, masih 'user'
        ]);

        return redirect()->route('dashboard')->with('success', 'Your request to become an organizer has been submitted!');
    }
}