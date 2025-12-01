<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('role'), function ($query) use ($request) {
                $query->where('role', $request->role);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $pendingCount = User::where('status', 'pending')->count(); // ← Hapus filter role

        return view('admin.users.index', compact('users', 'pendingCount'));
    }

    public function approve(Request $request, User $user)
    {
        if ($user->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        $user->update([
            'role' => 'organizer', 
            'status' => 'approved'
        ]);

        return back()->with('success', "{$user->name} has been approved as an organizer!");
    }


    public function reject(Request $request, User $user)
    {
        if ($user->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $user->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', "{$user->name}'s organizer request has been rejected.");
    }
}