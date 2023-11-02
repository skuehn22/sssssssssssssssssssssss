<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function autoLogin($token)
    {
        // Find the user by the token
        $user = User::where('login_token', $token)->first();

        // Check if a user was found
        if ($user) {
            // Log the user in
            Auth::login($user);

            // Store the user data in the session
            session(['user' => $user]);

            /*
            $task = Task::where('user_uid', Auth::id())
                ->where('task', 1)
                ->first();


            if(!$task || $task->vaule == '' || $task->value == null){

            }
            */

            if ($user->role == 2) {
                return redirect()->intended('/app/home');
            }

            if ($user->status == 1000) {
                return redirect('/app/task1/new');
            } else {
                return redirect()->intended('/app/home');
            }



            //return redirect()->intended('home');
        } else {
            // If the token is invalid, redirect to the login page
            return redirect()->route('login');
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
    }


    protected function credentials(Request $request)
    {
        return ['name' => $request->{$this->username()}, 'password' => $request->{$this->username()}];
    }


    public function username()
    {
        return 'name';
    }

    public function logout(Request $request)
    {
        // Logout the user from the application
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Forget the intended URL
        $request->session()->forget('url.intended');

        // Redirect to login page
        return redirect('/login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 2) {
            return redirect()->intended('/app/home');
        }

        if ($user->status == 1000) {
            return redirect('/app/task1/new');
        } else {
            return redirect()->intended('/app/home');
        }
    }

}
