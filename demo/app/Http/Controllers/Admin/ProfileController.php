<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the form for editing profile
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.profile.edit');
    }

    /**
     * Update profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        //update user
        $user = User::findOrFail(auth()->guard('admin')->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->title = $request->title;

        //optional updating password
        if (! empty($request['password'])) {
            $user->password = bcrypt($request->password);
        }

        //signature
        if ($request->hasFile('signature')) {
            //upload signature
            $signature = $request->file('signature');
            $signature_name = auth()->guard('admin')->user()->id.'.'.$signature->getClientOriginalExtension();
            $signature->move('uploads/signature', $signature_name);
            $user->signature = $signature_name;
        }
        if ($request->hasFile('signature2')) {
            //upload signature
            $signature2 = $request->file('signature2');
            $signature_name = auth()->guard('admin')->user()->id.'.'.$signature2->getClientOriginalExtension();
            $signature2->move('uploads/signature2', $signature_name);
            $user->signature2 = $signature_name;
        }
        if ($request->hasFile('signature3')) {
            //upload signature
            $signature3 = $request->file('signature3');
            $signature_name = auth()->guard('admin')->user()->id.'.'.$signature3->getClientOriginalExtension();
            $signature3->move('uploads/signature3', $signature_name);
            $user->signature3 = $signature_name;
        }
        if ($request->hasFile('signature4')) {
            //upload signature
            $signature4 = $request->file('signature4');
            $signature_name = auth()->guard('admin')->user()->id.'.'.$signature4->getClientOriginalExtension();
            $signature4->move('uploads/signature4', $signature_name);
            $user->signature4 = $signature_name;
        }

        //avatar
        if ($request->hasFile('avatar')) {
            //upload avatar
            $avatar = $request->file('avatar');
            $avatar_name = time().auth()->guard('admin')->user()->id.'.'.$avatar->getClientOriginalExtension();
            $avatar->move('uploads/user-avatar', $avatar_name);
            $user->avatar = $avatar_name;
        }

        $user->save();

        session()->flash('success', __('Profile updated successfully'));

        return redirect()->route('admin.profile.edit');

    }
}
