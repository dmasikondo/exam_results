<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Show the form for activating a user account
     */

    public function activate()
    {
        $token = auth()->user()->must_reset_password_token;
        return view('users.activate',['token'=>$token]);
    }


    /**
     * update (activate) the user account in database
     */
    public function activation(Request $request)
    {

        $request->validate([
        'first_name' => ['required', 'string', 'max:255','exists:users,first_name'],
        'second_name' => ['required', 'string', 'max:255', Rule::exists('users')
                ->where('first_name',request()->first_name)
                ->where('second_name',request()->second_name),
            ],
        'token' =>['required',  'max:255', Rule::exists('users', 'must_reset_password_token')
                ->where('first_name', auth()->user()->first_name)
                ->where('must_reset_password_token',$request->token)
            ],
        'password' => ['required', 'string', 'min:8', 'confirmed'],


        ]);

        $user = User::where('must_reset_password_token',request()->token)
            ->where('first_name', auth()->user()->first_name)
            ->firstOrFail();
        /**
         * if account is already active, do not activate
         */
        if(!$user->must_reset)
        {
           session()->flash('warning',"This account is already active. You can log in using your last successful password");
           return redirect()->back();
        }
        $user->update(['must_reset' =>0,'password'=>Hash::make(request('password'))]);
        
        session()->flash('message',"Your account was successfully activated. You can now login using your new password");
        Auth::logout();
         return redirect('/login') ;

    }
}
