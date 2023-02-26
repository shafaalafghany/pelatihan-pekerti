<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
	public function login() {
		return view('auth.login');
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
		
		$link = config('APP_URL') . 'auth/verify-email?id=' . $user->id . '&token=' . $token;
		$this->_sendEmail($request->email, $link);
		return view('auth.register', [
			'success' => 'silahkan cek email anda untuk melakukan verifikasi akun',
		]);
	}

	private function _sendEmail(string $email, string $url) {
		Mail::to($email)->send(new Register($email, $url));
	}
}
