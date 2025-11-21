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

        if (!$user || $user->role !== 'organizer') {
            abort(403, 'Unauthorized access.');
        }

        // Jika pending atau rejected, redirect ke dashboard (bukan pending page)
        if ($user->status === 'pending' || $user->status === 'rejected') {
            return redirect()->route('dashboard')->with('warning', 'Your organizer account is not yet approved.');
        }

        return $next($request);
    }
}