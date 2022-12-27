<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserApiController;
use App\Http\Controllers\Api\Profile\ProfileApiController;

/**
 * Authentication routes
 */
Route::prefix("/user/")
    ->as('users.')
    ->group(function () {
        Route::post('register/request', [UserApiController::class, 'registerRequest'])->name('register.request');
        Route::post('login/request', [UserApiController::class, 'loginRequest'])->name('login.request');
        Route::post('login/token', [UserApiController::class, 'loginToken'])->name('login.token');
    });

/**
 * Profile routes
 */
Route::prefix("/profile/")
    ->as('profile.')
    ->group(function () {
        Route::get('general', [ProfileApiController::class, 'general'])->name('general');
    });
