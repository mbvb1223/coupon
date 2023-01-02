<?php

use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\PointController;
use App\Http\Controllers\API\UserController;
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
Route::post('users/create', [UserController::class, 'create']);
Route::post('users/token', [UserController::class, 'token']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('points/lucky-draw', [PointController::class, 'luckyDraw']);

    Route::get('coupons', [CouponController::class, 'index']);
    Route::put('coupons/{coupon}', [CouponController::class, 'update']);
});
