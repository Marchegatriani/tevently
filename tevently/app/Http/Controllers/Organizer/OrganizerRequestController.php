<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrganizerRequestController extends Controller
{

    public function pending()
    {
        $user = Auth::user();
        
        if (!$user || $user->status !== 'pending') {
            return redirect()->route('dashboard');
        }
        
        return view('organizer.pending');
    }

    public function rejected()
    {
        $user = Auth::user();
        
        if (!$user || $user->status !== 'rejected') {
            return redirect()->route('dashboard');
        }
        
        return view('organizer.rejected');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->status !== 'rejected') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun.');
        }
        
        $userId = $user->id;
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        User::destroy($userId);
        
        return redirect()->route('login')->with('message', 'Akun telah dihapus. Anda dapat mendaftar kembali.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'user' && $user->status === 'approved') {
            $user->status = 'pending';
            return redirect()->route('organizer.pending')->with('success', 'Permohonan menjadi organizer telah dikirim.');
        }

        return redirect()->route('dashboard')->with('error', 'Anda tidak dapat mengirim permohonan saat ini.');
    }
}