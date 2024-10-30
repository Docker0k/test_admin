<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards): mixed
    {
        if (Auth::user()->isAdmin) {

            return $next($request);
        }
        return abort(404);
    }
}
