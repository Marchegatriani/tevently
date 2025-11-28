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

        // already organizer/admin → no action
        if (in_array($user->role, ['organizer','admin'])) {
            return redirect()->back()->with('info', 'Your account already has organizer access.');
        }

        // if already pending, keep user on pending page
        if ($user->status === 'pending') {
            return redirect()->route('organizer.pending')->with('info', 'Organizer request already pending.');
        }

        // mark user as pending
        $user->status = 'pending';
        $user->save();

        // optionally: notify admins / create request record (not implemented here)

        // redirect to pending page with message
        return redirect()->route('organizer.pending')->with('success', 'Organizer request submitted — please wait for admin approval.');
    }

    /**
     * Cancel organizer request — set status back to null (user keeps account).
     */
    public function cancel(Request $request)
    {
        $user = $request->user();

        if ($user->status !== 'pending') {
            return redirect()->route('dashboard')->with('info', 'Tidak ada permintaan yang sedang ditinjau.');
        }

        $user->status = null;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Permintaan organizer dibatalkan.');
    }
}