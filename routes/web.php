<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ItineraryController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\ReviewContrller;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

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

// Client
Route::get('/', [ClientController::class, 'index'])->name('index');
Route::get('/list-tours/{slug}', [ClientController::class, 'listTour'])->name('client.tours.list');
Route::get('/tours/{slug}', [ClientController::class, 'showTour'])->name('client.tours.detail');
Route::get('/tours/{slug}/booking', [ClientController::class, 'booking'])->name('client.booking.index');
Route::get('/contact', [ClientController::class, 'contact'])->name('client.contact');

// Admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('admin.password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('admin.password.update');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/change-password', [ChangePasswordController::class, 'create'])->name('admin.password.change');
        Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('admin.password.store');

        // Destination
        Route::resource('destinations', DestinationController::class)->except(['show']);
        Route::get('destinations/data', [DestinationController::class, 'getData'])->name('destinations.data');

        // Type of tour
        Route::group(['prefix' => 'types'], function () {
            Route::get('/', [TypeController::class, 'index'])->name('types.index');
            Route::post('/', [TypeController::class, 'store'])->name('types.store');
            Route::put('/{id}', [TypeController::class, 'update'])->name('types.update');
            Route::delete('/{id}', [TypeController::class, 'destroy'])->name('types.destroy');
            Route::get('data', [TypeController::class, 'getData'])->name('types.data');
        });

        // Tour
        Route::resource('tours', TourController::class)->except(['show']);
        Route::get('tours/data', [TourController::class, 'getData'])->name('tours.data');
        Route::group(['prefix' => 'tours/{tour_id}'], function () {
            //Addition Info
            Route::get('addition-info', [TourController::class, 'info'])->name('tours.info');

            // List image (Gallery)
            Route::prefix('galleries')->group(function () {
                Route::get('/', [GalleryController::class, 'index'])->name('galleries.index');
                Route::post('/', [GalleryController::class, 'store'])->name('galleries.store');
                Route::delete('/{id}', [GalleryController::class, 'destroy'])->name('galleries.destroy');
            });

            // Itinerary
            Route::prefix('itineraries')->group(function () {
                Route::get('/', [ItineraryController::class, 'index'])->name('itineraries.index');
                Route::post('/', [ItineraryController::class, 'store'])->name('itineraries.store');
                Route::put('/{id}', [ItineraryController::class, 'update'])->name('itineraries.update');
                Route::delete('/{id}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');
                Route::get('/data', [ItineraryController::class, 'getData'])->name('itineraries.data');

                // Place
                Route::prefix('/{itinerary_id}')->group(function () {
                    Route::resource('places', PlaceController::class)->except(['show']);
                    Route::get('places/data', [PlaceController::class, 'getData'])->name('places.data');
                });
            });

            // FAQ
            Route::resource('faqs', FAQController::class)->except(['show']);
            Route::get('faqs/data', [FAQController::class, 'getData'])->name('faqs.data');

            // Review
            Route::prefix('reviews')->group(function () {
                Route::get('/', [ReviewContrller::class, 'index'])->name('reviews.index');
                Route::get('/data', [ReviewContrller::class, 'getData'])->name('reviews.data');
                Route::put('/{review_id}/status', [ReviewContrller::class, 'changeStatus'])->name('reviews.status');
            });
        });

        // Booking
        Route::prefix('bookings')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
            Route::get('/show/{id}', [BookingController::class, 'show'])->name('bookings.show');
            Route::put('/{id}/change-status', [BookingController::class, 'changeStatus'])->name('bookings.status');
            Route::get('/data', [BookingController::class, 'getData'])->name('bookings.data');
        });

        // Contact
        Route::prefix('contacts')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
            Route::get('/show/{id}', [ContactController::class, 'show'])->name('contacts.show');
            Route::get('/data', [ContactController::class, 'getData'])->name('contacts.data');
        });
    });
});
