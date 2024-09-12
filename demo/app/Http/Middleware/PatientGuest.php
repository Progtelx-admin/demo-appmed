<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PatientGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('patient')->check()) {
            return redirect()->route('patient.index');
        }

        return $next($request);
    }
}
