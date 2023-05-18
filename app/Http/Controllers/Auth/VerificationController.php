<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        // $this->middleware('auth');
        $this->middleware('email')->only('verify');
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            session()->flash('verify', 'Email anda telah terverifikasi sebelumnya, silahkan login menggunakan akun anda.');

            return redirect('/login');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

    
        session()->flash('message', 'Email anda telah terverifikasi, silahkan login menggunakan akun anda.');
        session()->flash('type', 'success');
        return redirect()->to(route('verify_email'));
    }

    public function EmailResponse(string $message = null) {
        if ($message == null) {
            return view('auth.verify_email');
        }

        return view('auth.verify_email', [
            'error' => $message,
          ]);
    }
}
