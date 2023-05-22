<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Models\Admin;
use App\Models\Pelatihan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::guard('admin')) {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/dashboard');
    }

    return redirect('/login');
})->name('default_page');

Route::get('/home', function () {
    // $admin = Auth::guard('admin');
    // $user = Admin::find($admin->id());
    // dd($user['role']);
    // dd(Auth::user());
    // dd(auth()->user());
    if (Auth::guard('admin')) {
        return redirect('/admin/dashboard');
    }
    return redirect('/dashboard');
})->name('home');

// Route::controller(AuthController::class)->group(function () {
//     Route::get('/register', 'register')->middleware([GuestMiddleware::class]);
//     Route::post('/register', 'doRegister')->middleware([GuestMiddleware::class]);
//     // Route::get('/login', 'showLoginForm');
//     Route::get('/verify-email', 'verifyEmail')->middleware([GuestMiddleware::class]);
//     Route::post('/login', 'login')->middleware([GuestMiddleware::class]);
//     Route::get('/logout', 'logout');
// });
// Route::get('/login', 'showLoginForm@LoginController');

// Admin
Route::group(['middleware' => 'role:admin'], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');

    // Berkas
    Route::get('admin/dashboard/validasi-berkas', [BerkasController::class, 'ShowValidasiBerkas'])->name('validasi_berkas');
    Route::get('admin/dashboard/validasi-berkas/detail/{id_peserta}', [BerkasController::class, 'ShowValidasiBerkasDetail'])->name('validasi_berkas_detail');
    Route::post('validasi-berkas/terima/{id_peserta}/{id_pelatihan}', [BerkasController::class, 'TerimaValidasiBerkas']);
    Route::post('validasi-berkas/tolak/{id_peserta}', [BerkasController::class, 'TolakValidasiBerkas']);

});

// Dosen
Route::group(['middleware' => 'role:web'], function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    //Users
    Route::get('dashboard/profil', [UserController::class, 'ShowProfil'])->name('profil');
    Route::get('dashboard/profil/edit-profil', [UserController::class, 'ShowEditProfil'])->name('edit_profil');
    Route::post('profil/perbarui-profil', [UserController::class, 'UpdateProfil']);
    
    //Pelatihan
    Route::get('dashboard/pelatihan', [PelatihanController::class, 'ShowDaftarPelatihan'])->name('pelatihan');
    Route::get('dashboard/pelatihan/{id_pelatihan}/cek-data-diri', [PelatihanController::class, 'ShowLanjutDaftarPelatihan'])->name('lanjut_daftar_pelatihan');
    Route::post('pelatihan/daftar/{id_pelatihan}', [PelatihanController::class, 'DaftarPelatihan']);

    // Pembayaran
    Route::get('dashboard/pembayaran', [PembayaranController::class, 'ShowPembayaran'])->name('pembayaran');
    Route::get('pembayaran/{id_pembayaran}/invoice', [PembayaranController::class, 'ShowInvoice']);
    Route::post('pembayaran/{id_pelatihan}', [PembayaranController::class, 'AddPembayaran']);
});

// Auth
Auth::routes();
Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['email']);
Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');
Route::get('/verify-email', function () {
    return view('auth.verify_email');
})->name('verify_email');
