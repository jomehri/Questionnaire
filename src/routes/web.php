<?php

use Illuminate\Support\Facades\Route;
use Ybazli\Faker\Facades\Faker;

Route::get('/', function () {
    dd(Faker::address());
    return "up and working, checkout our <a href='" . env("APP_URL") . "/api/documentation' target='_blank'>swagger</a>";
});
