<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Organizer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Not logged in -> redirect to login
        if (!$user) {
            return redirect()->route('login');
        }

        // Check organizer status
        if ($user->status === 'pending') {
            return redirect()->route('organizer.pending');
        }

        if ($user->status === 'rejected') {
            return redirect()->route('organizer.rejected');
        }

        // Check if user is organizer
        if ($user->role !== 'organizer') {
            abort(403, 'Unauthorized access. Organizer only.');
        }

        return $next($request);
    }
}