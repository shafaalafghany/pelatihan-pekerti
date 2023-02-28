<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelatihanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Middleware\GuestMiddleware;

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

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->middleware([GuestMiddleware::class]);
    Route::post('/register', 'doRegister')->middleware([GuestMiddleware::class]);
    Route::get('/login', 'login')->middleware([GuestMiddleware::class]);
    Route::post('/login', 'doLogin')->middleware([GuestMiddleware::class]);
    Route::get('/verify-email', 'verifyEmail')->middleware([GuestMiddleware::class]);
    Route::get('/logout', 'logout');
});


Route::get('/dashboard', [PelatihanController::class, 'index'])->middleware([DosenMiddleware::class]);
Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware([AdminMiddleware::class])->name('admin-dashboard');

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
