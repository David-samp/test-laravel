<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use \App\Models\User;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

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

    /**
     * Launched when user just authenticate
     */
    function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString()
        ]);

    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \App\Http\Controllers\Auth\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        try {
            $username = $request->get('username');
            $user = User::where('email', $username)->first();
            if($user) {
                Auth::login($user);
                return redirect()->route('home');
            }
        } catch(\Throwable $e) {
            return redirect()->back()->with('error', trans('texts.transactionerror'));
        }
    }
}
