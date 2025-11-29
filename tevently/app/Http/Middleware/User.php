<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Jika tidak login, lanjutkan
        if (!$user) {
            return $next($request);
        }

        // Route yang diizinkan untuk pending/rejected users
        $allowedRoutes = [
            'organizer.pending',
            'organizer.rejected',
            'organizer.cancel',
            'organizer.request',
            'logout'
        ];

        // Jika sedang mengakses route yang diizinkan, lanjutkan
        if ($request->routeIs($allowedRoutes)) {
            return $next($request);
        }

        // Jika user PENDING - BLOKIR semua akses kecuali pending page
        if ($user->status === 'pending') {
            return redirect()->route('organizer.pending');
        }

        // Jika user REJECTED - BLOKIR semua akses kecuali rejected page
        if ($user->status === 'rejected') {
            return redirect()->route('organizer.rejected');
        }

        return $next($request);
    }
}