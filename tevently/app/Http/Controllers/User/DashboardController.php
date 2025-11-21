<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_favorites' => $user->favoriteEvents()->count(),
        ];

        return view('dashboard', $stats);
    }
}