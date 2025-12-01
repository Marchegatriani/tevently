<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->status === 'pending') {
            return redirect()->route('organizer.pending');
        }
        
        if ($user->status === 'rejected') {
            return redirect()->route('organizer.rejected');
        }
    
        return view('user.home', [
            'user' => $user
        ]);
    }
}