<?php

use App\Http\Controllers\User\StoreRentController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TourController;


// AUTH ROUTES
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('verify-account', [AuthController::class, 'verifyAccount']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

//load destination listing without auth
Route::get('get-all-tours',[TourController::class,'index']);
Route::get('get-tour/{tour}',[TourController::class,'show']);

Route::middleware('auth:user_api')->group(function () {
    Route::get('user', function () {
        return new UserResource(request()->user());
    });
    //User Other Route
    

    Route::post('logout', [AuthController::class, 'logout'])->name('user_logout');
});
