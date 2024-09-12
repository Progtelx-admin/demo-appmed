<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\UserBranch;
use App\Models\Visit;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todays visits
        $today_visits = Visit::with('patient')
            ->where('branch_id', session('branch_id'))
            ->whereDate('visit_date', now())
            ->get();

        //all branches
        $all_branches = Branch::all();

        return view('admin.index', compact(
            'today_visits',
            'all_branches'
        ));
    }

    public function change_branch(Request $request, $id)
    {
        $branch = UserBranch::where([
            ['branch_id', $id],
            ['user_id', auth()->guard('admin')->user()->id],
        ])->first();

        if ($branch) {
            session()->put('branch_id', $branch['branch_id']);
            session()->put('branch_name', $branch['branch']['name']);

            session()->flash('success', __('Branch changed successfully'));

            return redirect()->route('admin.index');
        } else {
            session()->flash('failed', __('You aren\'t authorized to browse this branch'));

            return redirect()->back('admin.index');
        }
    }


    public function update_point_of_sale(Request $request)
    {
        $user = User::find(Auth::guard('admin')->user()->id);

        if ($user) {
            $user->point_of_sale_id = $request->input('point_of_sale_id');
            $user->save();

            session()->flash('success', __('Point of sale updated successfully'));

            return redirect()->route('admin.pos_transactions.index');
        } else {
            session()->flash('failed', __('Failed to update point of sale'));

            return redirect()->back();
        }
    }
}
