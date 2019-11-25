<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Show change password form
     */
    public function getChangePasswordForm()
    {
        return view('change-password');
    }

    /**
     * Change password
     */
    public function postChangePasswordForm()
    {
        request()->validate([
            'old_password'      => 'required',
            'password'          => 'required|confirmed|min:6'
        ]);
        if (!(Hash::check(request()->get('old_password'), Auth::user()->password)))
            return redirect()->back()->with('danger', 'Current password does not match our records');

        if (strcmp(request()->get('old_password'), request()->get('password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("danger", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $user = Auth::user();
        $user->password = Hash::make(request()->get('password'));
        $user->remember_token = Str::random(20);
        $user->save();

        return redirect()->back()->with('success', 'Password successfully changed!');
    }
}
