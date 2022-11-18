<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Sale\UserCoinApiController;

Route::put('user/coins/purchase', [UserCoinApiController::class, 'newPurchase']);
