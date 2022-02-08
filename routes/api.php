<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth
Route::post('signup', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify', [AuthController::class, 'verify']);
Route::post('send-code', [AuthController::class, 'sendCode']);
Route::put('reset-password', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::put('change-password', [AuthController::class, 'changePassword']);
    Route::get('users', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);

    //Tour
    Route::apiResource('tours', TourController::class)->except(['show', 'update']);
});

//Tour


//Fallback
Route::fallback(function () {
    return response()->json([
        'message' => 'API Not Found. If error persists, contact support@website.com'
    ], 404);
});
