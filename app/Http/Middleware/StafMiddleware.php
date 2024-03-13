<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StafMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'magang') {
            return redirect('/admin');
        }

        return $next($request);

    }
}
