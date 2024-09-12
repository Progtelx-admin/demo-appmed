<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            return redirect('admin');
        }

        return $next($request);
    }
}
