<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Mail\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{

	use AuthenticatesUsers;

	// public function login() {
	// 	return view('auth.login');
	// }

	protected function attemptLogin(Request $request)
    {
        return Auth::guard($request->role == 'admin' ? 'admin' : 'web')->attempt(['email' => $request->email, 'password' => $request->password]);
    }


	public function doLogin(Request $request) {
		$credential = $request->validate([
			'email' => 'required',
			'password' => 'required',
			'role' => 'required',
		]);

		$email = $request->email;
		$password = $request->password;

		if (Auth::guard($request->role == 'admin' ? 'admin' : 'web')->attempt(['email' => $email, 'password' => $password])) {
			$request->session()->regenerate();

			// return redirect()->to(route('admin-dashboard'));
			return redirect()->intended();
	}

		// if ($request->role == 'admin') {
		// 	return $this->_adminLogin($request, $email, $password);
		// } else {
		// 	return $this->_dosenLogin($request, $email, $password);
		// }
	}

	public function register() {
		return view('auth.register');
	}

	public function doRegister(Request $request) {
		$request->validate([
			'email' => 'required|unique:dosen,email|max:150',
			'fullname' => 'required|max:255',
			'password' => 'required|min:6',
		]);

		$token = Str::random(64);
		$user = new User();
		$user->email = $request->email;
		$user->fullname = $request->fullname;
		$user->password = Hash::make($request->password);
		$user->is_active = 0;
		$user->token_verification = $token;
		$user->token_expired = Carbon::now()->addDay(1)->timestamp;
		
		if (!$user->save()) {
			return view('auth.register', [
				'error' => 'Terjadi kesalahan pada sistem, mohon tunggu sejenak',
			]);
		}
		
		$link = 'http://localhost:8000/verify-email?id=' . $user->id . '&token=' . $token;
		$this->_sendEmail($request->email, $link);
		return view('auth.register', [
			'success' => 'silahkan cek email anda untuk melakukan verifikasi akun',
		]);
	}

	public function verifyEmail(Request $request) {
		$id = $request->input('id');
		$token = $request->input('token');
		$now = Carbon::now()->timestamp;
		$user = User::find($id);

		if ($now > $user->token_expired) {
			return view('auth.verify_email', [
				'error' => 'user tidak ditemukan atau token telah kedaluarsa',
			]);
		}
		
		if ($user->token_verification != $token) {
			return view('auth.verify_email', [
				'error' => 'user tidak ditemukan atau token telah kedaluarsa',
			]);
		}

		$user->is_active = 1;
		$user->token_verification = null;
		$user->token_expired = null;
		
		if(!$user->save()) {
			return view('auth.verify_email', [
				'error' => 'terjadi kesalahan pada sistem, mohon tunggu sejenak',
			]);
		}

		return view('auth.verify_email');
	}

	public function logout(Request $request) {
		// $role = $request->input('role');

		// if ($role == 'admin') {
		// 	$request->session()->forget($role);
		// } else {
		// 	$request->session()->forget($role);
		// }

		// return redirect('/login');
		Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
	}

	private function _sendEmail(string $email, $url) {
		Mail::to($email)->send(new Register($email, $url));
	}

	private function _adminLogin(Request $request, string $email, $password) {
		$admin = Admin::where('email', $email)->first();
		if ($admin == null) {
			return view('auth.login', [
				'error' => 'email atau password anda salah',
			]);
		}

		$isPasswordValid = $this->_checkPassword($admin->password, $password);
		if (!$isPasswordValid) {
			return view('auth.login', [
				'error' => 'email atau password anda salah',
			]);
		}

		$request->session()->put('admin', $admin->id);
		return view('admin.dashboard');
	}

	private function _dosenLogin(Request $request, string $email, $password) {
		$user = User::where('email', $email)->first();
		if ($user == null) {
			return view('auth.login', [
				'error' => 'email atau password anda salah',
			]);
		}

		if ($user->is_active == 0) {
			return view('auth.login', [
				'error' => 'silahkan melakukan verifikasi email terlebih dahulu sebelum login',
			]);
		}

		$isPasswordValid = $this->_checkPassword($user->password, $password);
		if (!$isPasswordValid) {
			return view('auth.login', [
				'error' => 'email atau password anda salah',
			]);
		}

		$request->session()->put('dosen', $user->id);
		return view('dashboard');
	}

	private function _checkPassword(string $hashedPassword, $plainPassword) {
		return Hash::check($plainPassword, $hashedPassword);
	}
}
