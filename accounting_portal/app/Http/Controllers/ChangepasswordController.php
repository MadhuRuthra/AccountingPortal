<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


// This Controller use to Change the password
class ChangepasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        return view('changepassword');
    }

    public function changePasswordSave(Request $request)
    {

        //Validation for Current and New password
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);
        $auth = Auth::user();

        // The passwords matches
        if (!Hash::check($request->get('current_password'), auth()->user()->password)) {
            return back()->with('error', "Old Password Doesn't match!");
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        // The user based on their ID and then updating the password attribute with the hashed version of the new password.
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('home')->with('success', "password Changed Successfully"); // Password changed successfully and return redirect from home page
    }

}