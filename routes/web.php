<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelatihanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Middleware\GuestMiddleware;
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
    return view('welcome');
})->name('landing-page');

// Route::controller(AuthController::class)->group(function () {
//     Route::get('/register', 'register')->middleware([GuestMiddleware::class]);
//     Route::post('/register', 'doRegister')->middleware([GuestMiddleware::class]);
//     // Route::get('/login', 'showLoginForm');
//     Route::get('/verify-email', 'verifyEmail')->middleware([GuestMiddleware::class]);
//     Route::post('/login', 'login')->middleware([GuestMiddleware::class]);
//     Route::get('/logout', 'logout');
// });
// Route::get('/login', 'showLoginForm@LoginController');
    Route::get('/verify-email', function () {
        return view('auth.verify_email');
    })->name('verify_email');



// Route::get('/dashboard', [PelatihanController::class, 'index'])->middleware([DosenMiddleware::class]);
// Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware([AdminMiddleware::class])->name('admin-dashboard');
Route::group(['middleware'=>'role:admin'], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
});
Route::group(['middleware'=>'role:web'], function () {
    Route::get('dashboard', [PelatihanController::class, 'index'])->name('dashboard');
});

// Route::controller(PelatihanController::class)->middleware([DosenMiddleware::class])->group(function () {
//     Route::get('/dashboard', 'index');
// });

// Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
//     Route::controller(AdminController::class)->group(function () {
//         Route::get('/dashboard', 'index');
//     });
// });

// Route::view('/admin/dashboard', function () {
//     return view('dashboard');
// })->middleware([DosenMiddleware::class]);

Auth::routes();
Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['email']);
Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', function () {
    // dd(auth()->guard('admin')->user());
    // dd(auth()->user());
    return view('welcome');
})->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
