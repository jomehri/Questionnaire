<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserApiController;

Route::prefix("/user/")
    ->group(function () {
        Route::post('auth/requestPinCode', [UserApiController::class, 'requestPinCode']);
    });
