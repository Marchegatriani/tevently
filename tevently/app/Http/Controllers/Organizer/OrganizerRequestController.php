<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrganizerRequestController extends Controller
{
    /**
     * Show pending approval page
     */
    public function pending()
    {
        $user = Auth::user();
        
        // Pastikan user adalah organizer dengan status pending
        if (!$user || $user->status !== 'pending') {
            return redirect()->route('dashboard');
        }
        
        return view('organizer.pending');
    }

    /**
     * Show rejected page
     */
    public function rejected()
    {
        $user = Auth::user();
        
        // Pastikan user adalah organizer dengan status rejected
        if (!$user || $user->status !== 'rejected') {
            return redirect()->route('dashboard');
        }
        
        return view('organizer.rejected');
    }

    /**
     * Delete account for rejected organizer
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Validasi: hanya organizer yang rejected yang bisa hapus
        if (!$user || $user->status !== 'rejected') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun.');
        }
        
        // Simpan ID user sebelum logout
        $userId = $user->id;
        
        // Logout
        Auth::logout();
        
        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Hapus user menggunakan ID
        User::destroy($userId);
        
        return redirect()->route('login')->with('message', 'Akun telah dihapus. Anda dapat mendaftar kembali.');
    }

    /**
     * Store a new organizer request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Hanya user biasa yang bisa request
        if ($user->role === 'user' && $user->status === 'approved') {
            $user->status = 'pending';
            $user->save();
            return redirect()->route('organizer.pending')->with('success', 'Permohonan menjadi organizer telah dikirim.');
        }

        return redirect()->route('dashboard')->with('error', 'Anda tidak dapat mengirim permohonan saat ini.');
    }
}