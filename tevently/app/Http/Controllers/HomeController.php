<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Pakai $request->user()
        $user = $request->user();

        // Cek jika user tidak login
        if (!$user) {
            return redirect()->route('login');
        }

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'organizer') {
            if ($user->status === 'approved') {
                return redirect()->route('organizer.dashboard');
            }
            return redirect()->route('dashboard');
        }

        // Default: user biasa
        return redirect()->route('dashboard');
    }
}