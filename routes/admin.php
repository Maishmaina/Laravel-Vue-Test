<?php

use App\Http\Controllers\Admin\UnitsController;
use App\Http\Controllers\Admin\UnitSizeController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StorageTypeController;
use App\Http\Controllers\Admin\FacilityOwnerController;
use App\Http\Controllers\Admin\StorageSubtypeController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\TicketController;

Route::prefix('admin')->group(function () {
    // AUTH ROUTES
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('forgot-password', [AdminAuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AdminAuthController::class, 'resetPassword']);

    Route::middleware('auth:admin_api')->group(function () {
        Route::delete('logout', [AdminAuthController::class, 'logout']);

        // ADMIN ROUTES
        Route::apiResource('admins', AdminController::class);

        // USER ROUTES
        Route::apiResource('users', UserController::class);

        // ROLE ROUTES
        Route::apiResource('roles', RoleController::class);
        Route::post('sync-permissions', [RoleController::class, 'syncPermissions']);

        // PERMISSIONS
        Route::get('permissions', function () {
            return response()->json(Permission::get()->pluck('name'));
        });

     //OTHER APi ROUTES...
     Route::apiResource('destinations',DestinationController::class);
     Route::apiResource('tours',TourController::class);
     Route::apiResource('bookings',BookingController::class);
     Route::apiResource('tickets',TicketController::class);
     
    });
});
