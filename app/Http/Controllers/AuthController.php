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

	private function _sendEmail(string $email, string $url) {
		Mail::to($email)->send(new Register($email, $url));
	}
}
