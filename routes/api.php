<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\VerificationController;
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
Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify', [VerificationController::class, 'verify']);
Route::post('send-code', [VerificationController::class, 'sendCode']);
Route::put('reset-password', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'user']);
    Route::put('change-password', [AuthController::class, 'changePassword']);

});

//Tour
Route::get('test', function (TourController $tourController) {
    return json_encode($tourController->index());
});
Route::apiResource('tours', TourController::class)->except(['show', 'update']);

//Fallback
Route::fallback(function () {
    return response()->json([
        'message' => 'API Not Found. If error persists, contact support@website.com'
    ], 404);
});
