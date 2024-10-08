<?php

namespace App\Http\Middleware;

use App\Models\UserBranch;
use Closure;

class Branch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $branch = UserBranch::where([
            'branch_id' => session('branch_id'),
            'user_id' => auth()->guard('admin')->user()->id,
        ])->first();

        if (! $branch) {
            auth()->guard('admin')->logout();

            session()->flash('failed', 'Branch doesn\'t exist');

            return redirect()->route('admin.auth.login');
        }

        return $next($request);
    }
}
