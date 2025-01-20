<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
        Route::post('subscribe', [SubscriptionController::class, 'subscribe']);
        Route::post('unsubscribe', [SubscriptionController::class, 'unsubscribe']);
        Route::get('subscription', [SubscriptionController::class, 'show']);
        Route::get('subscriptions', [SubscriptionController::class, 'index']);
    });

