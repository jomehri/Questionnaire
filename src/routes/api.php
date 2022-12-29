<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserApiController;
use App\Http\Controllers\Api\Profile\ProfileApiController;
use App\Http\Controllers\Api\Questions\QuestionerApiController;

/**
 * Authentication routes
 */
Route::prefix("/user/")
    ->as('users.')
    ->group(function () {
        Route::post('register/request', [UserApiController::class, 'registerRequest'])->name('register.request');
        Route::post('login/request', [UserApiController::class, 'loginRequest'])->name('login.request');
        Route::post('login/token', [UserApiController::class, 'loginToken'])->name('login.token');

        Route::get('logout', [UserApiController::class, 'logout'])
            ->name('logout')
            ->middleware('auth:sanctum');
    });

/**
 * Profile routes
 */
Route::prefix("/profile/")
    ->as('profile.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('general', [ProfileApiController::class, 'general'])->name('general');
    });

/**
 * Questioner routes
 */
Route::prefix("/questioners/")
    ->as('questioners.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', [QuestionerApiController::class, 'store'])->name('create');
        Route::post('{questioner:id}', [QuestionerApiController::class, 'update'])->name('update');
        Route::get('{questioner:id}', [QuestionerApiController::class, 'item'])->name('item');
        Route::delete('{questioner:id}/delete', [QuestionerApiController::class, 'delete'])->name('delete');
    });
