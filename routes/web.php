<?php

use App\Http\Controllers\Admin\PlaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\TypeOfTourController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\GalleryController;
use \App\Http\Controllers\Admin\ItineraryController;

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
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('admin.password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('admin.password.update');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::get('/change-password', [ChangePasswordController::class, 'create'])->name('admin.password.change');
        Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('admin.password.store');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Destination
        Route::resource('destinations', DestinationController::class)->except(['show']);
        Route::group(['prefix' => 'destinations'], function () {
            Route::get('data', [DestinationController::class, 'getData'])->name('destinations.data');
        });

        // Type of tour
        Route::resource('types', TypeOfTourController::class)->except(['show']);
        Route::group(['prefix' => 'types'], function () {
            Route::get('data', [TypeOfTourController::class, 'getData'])->name('types.data');
        });

        // Tour
        Route::resource('tours', TourController::class)->except(['show']);
        Route::group(['prefix' => 'tours'], function () {
            Route::get('data', [TourController::class, 'getData'])->name('tours.data');

            // List image (Gallery)
            Route::prefix('/{tour_id}/galleries')->group(function () {
                Route::get('/', [GalleryController::class, 'index'])->name('galleries.index');
                Route::post('/', [GalleryController::class, 'store'])->name('galleries.store');
                Route::delete('/{id}', [GalleryController::class, 'destroy'])->name('galleries.destroy');
            });

            // Itinerary
            Route::prefix('/{tour_id}/itineraries')->group(function () {
                Route::get('/', [ItineraryController::class, 'index'])->name('itineraries.index');
                Route::post('/', [ItineraryController::class, 'store'])->name('itineraries.store');
                Route::post('/update', [ItineraryController::class, 'update'])->name('itineraries.update');
                Route::delete('/{id}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');
                Route::get('/data', [ItineraryController::class, 'getData'])->name('itineraries.data');

            });

            // Place
            Route::prefix('/itineraries/{itinerary_id}/')->group(function () {
                Route::resource('places', PlaceController::class)->except(['show']);
                Route::group(['prefix' => 'places'], function () {
                    Route::get('data', [PlaceController::class, 'getData'])->name('places.data');
                });
            });

        });


    });
});
