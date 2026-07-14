<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Cookie;

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
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        Session::put('backUrl', URL::previous());
    }

    public function login(Request $request)
    {
        if (!$request->has('_token')) {
            if ($this->attemptLogin($request)) {
                session()->put('auth_user', Auth::id());
                Cookie::queue('auth_user', Auth::id(), 60 * 24);
                return response()->json(['api' => Auth::guard('api')->user(),'user' => User::find(Auth::id()),'status' => 'success']);
            }
            return $this->sendFailedJsonLoginResponse($request);
        } else {
            $this->validateLogin($request);
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function redirectTo()
    {
        return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
    }

    protected function sendFailedJsonLoginResponse(Request $request)
    {
        if (!User::where('email', $request->email)->first()) {
            return response()->json([
                'status' => trans('auth.failed'),
                'email' => trans('auth.email')], 401);
        }

        if (!User::where('email', $request->email)->where('password', bcrypt($request->password))->first()) {
            return response()->json([
                'status' => trans('auth.failed'),
                'password' => trans('auth.password')
            ], 401);
        }

        return response()->json([
            'status' => trans('auth.failed'),
        ], 401);
    }
}
