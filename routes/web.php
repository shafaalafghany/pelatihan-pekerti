<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\DokumenRiwayatController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SesiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Models\Admin;
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
    Route::get('admin/dashboard/tambah-admin', [AdminController::class, 'ShowTambahAdmin'])->name('tambah_admin');
    Route::post('buat-admin', [AdminController::class, 'TambahAdmin']);

    //Pelatihan
    Route::get('admin/dashboard/pelatihan', [PelatihanController::class, 'AdminShowPelatihan'])->name('admin_pelatihan');
    Route::get('admin/dashboard/pelatihan/buat-pelatihan', [PelatihanController::class, 'AdminBuatPelatihan']);
    Route::get('admin/dashboard/pelatihan/{id_pelatihan}', [PelatihanController::class, 'AdminShowPelatihanDetail']);
    Route::post('pelatihan/buat', [PelatihanController::class, 'BuatPelatihan']);

    //Tugas
    Route::get('admin/dashboard/tugas', [TugasController::class, 'AdminShowTugas'])->name('admin_tugas');
    Route::get('admin/dashboard/tugas/{id_pelatihan}/buat', [TugasController::class, 'AdminBuatTugas']);
    Route::get('admin/dashboard/tugas/detail/{id_tugas}', [TugasController::class, 'AdminTugasDetail']);
    Route::get('admin/dashboard/tugas/detail/{id_tugas}/{id_tugas_dosen}', [TugasController::class, 'AdminShowTugasDosen']);
    Route::post('admin/dashboard/tugas/detail', [TugasController::class, 'AdminShowTugasDetail']);
    Route::post('tugas/buat', [TugasController::class, 'BuatTugas']);

    //Sesi
    Route::get('admin/dashboard/sesi', [SesiController::class, 'AdminShowSesi'])->name('admin_sesi');
    Route::get('admin/dashboard/sesi/{id_pelatihan}', [SesiController::class, 'AdminShowSesiDetail']);
    Route::get('admin/dashboard/sesi/{id_pelatihan}/buat', [SesiController::class, 'AdminBuatSesi']);
    Route::post('sesi/buat', [SesiController::class, 'BuatSesi']);
    Route::post('sesi/pilih-pelatihan', [SesiController::class, 'AdminPilihPelatihan']);

    //Presensi
    Route::get('admin/dashboard/presensi', [PresensiController::class, 'AdminShowPresensi'])->name('admin_presensi');
    Route::get('admin/dashboard/presensi/{id_pelatihan}', [PresensiController::class, 'AdminShowPrensensiDetail']);
    Route::get('admin/dashboard/presensi/{id_pelatihan}/buat', [PresensiController::class, 'AdminBuatPresensi']);
    Route::get('admin/dashboard/presensi/{id_pelatihan}/{id_sesi}', [PresensiController::class, 'AdminShowPresensiDetailSesi']);
    Route::post('presensi/sesi', [PresensiController::class, 'PilihPelatihan']);
    Route::post('presensi/buat', [PresensiController::class, 'BuatPresensi']);

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

    //Sesi
    Route::get('dashboard/sesi', [SesiController::class, 'ShowSesi'])->name('sesi');

    //Presensi
    Route::get('dashboard/presensi', [PresensiController::class, 'ShowPresensi'])->name('presensi');
    Route::post('presensi', [PresensiController::class, 'CekPresensi']);

    //Tugas
    Route::get('dashboard/tugas', [TugasController::class, 'ShowTugas'])->name('tugas');
    Route::get('dashboard/tugas/{id_tugas}', [TugasController::class, 'ShowTugasDetail']);
    Route::post('tugas/{id_tugas}', [TugasController::class, 'KumpulTugas']);

    // Pembayaran
    Route::get('dashboard/pembayaran', [PembayaranController::class, 'ShowPembayaran'])->name('pembayaran');
    Route::get('pembayaran/{id_pembayaran}/invoice', [PembayaranController::class, 'ShowInvoice']);
    Route::post('pembayaran/{id_pelatihan}', [PembayaranController::class, 'AddPembayaran']);

    //Cetak Dokumen
    Route::get('dashboard/cetak-dokumen', [DokumenRiwayatController::class, 'ShowDokumenRiwayatTest'])->name('cetak_dokumen');
    Route::get('cetak-dokumen/kartu-peserta/{id_kartu_peserta}', [DokumenRiwayatController::class, 'ShowKartuPeserta']);
    Route::get('cetak-dokumen/sertifikat/{id_sertifikat}', [DokumenRiwayatController::class, 'ShowSertifikat']);
});

// Auth
Auth::routes();
Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['email']);
Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');
Route::get('/verify-email', function () {
    return view('auth.verify_email');
})->name('verify_email');
