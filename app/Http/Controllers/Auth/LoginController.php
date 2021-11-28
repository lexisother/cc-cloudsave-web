<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    public function login(Request $request) {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            if (str_contains($request->fullUrl(), 'api')) {
                return response()->json(['data' => $user->toArray()], 200);
            } else {
                return redirect()->intended('/');
            }
        }
    }

    public function logout(Request $request) {
        if (str_contains($request->fullUrl(), 'api')) {
            $user = Auth::guard('api')->user();

            if ($user) {
                $user->api_token = null;
                $user->save();
            }

            return response()->json(['data' => 'User logged out.'], 200);
        } else {
            // NOTE: I have no idea how to access the user object from here.
            // The API key is thus NOT regenerated!!!
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();


            return redirect()->intended('/');
        }
    }
}
