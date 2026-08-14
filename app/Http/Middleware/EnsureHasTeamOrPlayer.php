<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasTeamOrPlayer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()->currentTeam()) {
            return redirect('/hub');
        }

        return $next($request);
    }
}
