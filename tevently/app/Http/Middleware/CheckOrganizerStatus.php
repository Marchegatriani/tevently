<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizerStatusOrganizer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $allowedRoutes = [
            'organizer.pending',
            'organizer.rejected',
            'organizer.cancel',
            'logout'
        ];

        if ($request->routeIs($allowedRoutes)) {
            return $next($request);
        }

        if ($user->status === 'pending') {
            return redirect()->route('organizer.pending');
        }

        if ($user->status === 'rejected') {
            return redirect()->route('organizer.rejected');
        }

        if ($user->role !== 'organizer' || $user->status !== 'approved') {
            abort(403, 'Unauthorized access. Approved organizer only.');
        }

        return $next($request);
    }
}