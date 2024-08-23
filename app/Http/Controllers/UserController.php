<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * show all the users
     */
    public function index()
    {
        Gate::authorize('view', User::class);

        //check for requested number of pages to be displayed
        if(request()->perPage && intval(request()->perPage) > 0){
            $numberOfRecordsPerPage = request()->perPage;
        }
        else{
            $numberOfRecordsPerPage = 20;
        }
        $roles = Role::orderBy('name')->get();
        $users = User::filters(request(['role','surname','first_name','email']))
         ->with('roles','staff.department')
         ->paginate($numberOfRecordsPerPage)->withQueryString();

        return view('users.index', compact('roles','users'));
    }

    /**
     * Show the form for registering users
     * To IT mgr & IT Unit
     */
    public function create()
    {
        Gate::authorize('create', User::class);
        $roles =Role::orderBy('name')->get();
        $departments =Department::orderBy('name')->get();
        return view('users.create', compact('roles','departments'));
    }

    /**
     * Store the newly created user in storage
     */

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $slug = request()->surname.uniqid();
        $user= User::create([
            'slug' =>$slug,
            'second_name' =>request()->last_name,
            'first_name' =>request()->first_name,
            'email' => request()->email,
            'must_reset'=>true,
            'password' => Hash::make(request()->password),
            'must_reset_password_token'=>Str::random(60),
        ]);
        $user->staff()->create(['user_id'=>$user->id,'department_id'=>request()->department]);
        $user->roles()->sync(request()->role);
        session()->flash('message',"User was successfully registered");
         return redirect('/users/registration') ;

    }

    public function edit(User $user)
    {
        Gate::authorize('create', User::class);
        $roles =Role::orderBy('name')->get();
        $departments =Department::orderBy('name')->get();

        return view ('users.create', compact('user','roles','departments'));
    }

    public function update(Request $request, User  $user)
    {
        Gate::authorize('create', User::class);
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role' => ['required_with:department', 'string', 'max:255'],
            'department' => ['required_with:role', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);

        $user->update([
            'second_name' =>request()->last_name,
            'first_name' =>request()->first_name,
            'email' => request()->email,
            'must_reset'=>true,
            'password' => Hash::make(request()->password),
            'must_reset_password_token'=>Str::random(60),
        ]);

        $user->staff()->update(['department_id'=>request()->department]);
        $user->roles()->sync(request()->role);
        session()->flash('message',"User was successfully updated");

        return redirect('/users/registration') ;
    }
    /**
     * Show the form for activating a user account
     */

    public function activate()
    {
        Gate::authorize('activate', User::class);
        $token = auth()->user()->must_reset_password_token;
        return view('users.activate',['token'=>$token]);
    }


    /**
     * update (activate) the user account in database
     */
    public function activation(Request $request)
    {
        Gate::authorize('activate', User::class);

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
