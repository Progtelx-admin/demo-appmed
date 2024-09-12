<?php

namespace App\Http\Middleware;

use Closure;

class Install
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! \Schema::hasTable('migrations')) {
            return redirect('install');
        }

        return $next($request);
    }
}
