<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
        $this->middleware('guest:admin')->except('logout');
        // dd(url()->previous());
    }
    protected function attemptLogin(Request $request)
    {
        return Auth::guard($request->role == 'admin' ? 'admin' : 'web')->attempt(['email' => $request->email, 'password' => $request->password]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        // dd(session()->get('url.intended'));
        $user = User::whereEmail($request->email)->first();
        // dd($user && !$user->email_verified_at && $request->role == 'dosen',$user , !$user->email_verified_at , $request->role == 'dosen') ;
        if ($user && !$user->email_verified_at && $request->role == 'dosen') {
            session()->flash('message', 'Email anda belum diverifikasi');
            session()->flash('type', 'error');

            return redirect()->to(route('verify_email'));
            // ('VerificationController@EmailResponse', ['message' => 'anda belum melakukan verifikasi email, silahkan periksa email anda kembali']);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
