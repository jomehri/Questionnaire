<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserApiController;

Route::prefix("/user/")
    ->group(function () {
        Route::post('register/request', [UserApiController::class, 'registerRequest']);
        Route::post('login/request', [UserApiController::class, 'loginRequest']);
    });
