<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
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

require __DIR__.'/auth.php';
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('admin.password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('admin.password.update');

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    });
});


