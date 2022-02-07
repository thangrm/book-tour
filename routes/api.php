<?php

use App\Http\Controllers\Api\TourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'api\UserController@details');
});

Route::get('test', function (TourController $tourController) {
    return json_encode($tourController->index());
});
Route::apiResource('tours', TourController::class)->except(['show', 'update']);
