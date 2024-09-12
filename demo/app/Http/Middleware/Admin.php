<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserBranch;
use App\Models\PointOfSale;
use Auth;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Schema::hasTable('migrations')) {
            if (! Auth::guard('admin')->check()) {
                return redirect()->route('admin.auth.login');
            }

            //add online
            $user = User::where('id', auth()->guard('admin')->user()->id)
                ->update([
                    'last_activity' => now(),
                ]);

            $userPos = User::find(Auth::guard('admin')->user()->id);

            // Get all point of sales
            $pointOfSales = PointOfSale::all();

            //share settings
            $info = setting('info');
            $whatsapp = setting('whatsapp');
            $email = setting('emails');
            $api_keys = setting('api_keys');
            $user_branches = UserBranch::where('user_id', auth()->guard('admin')->user()->id)
                ->has('branch')
                ->where('branch_id', '!=', session('branch_id'))
                ->groupby('branch_id')
                ->distinct()
                ->get();
            view()->share([
                'info' => $info,
                'whatsapp' => $whatsapp,
                'api_keys' => $api_keys,
                'email' => $email,
                'user_branches' => $user_branches,
                'userPos' => $userPos,
                'pointOfSales' => $pointOfSales,
            ]);
        }

        return $next($request);
    }
}
