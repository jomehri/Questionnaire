<?php

use Illuminate\Support\Facades\Route;
use Ybazli\Faker\Facades\Faker;

Route::get('/', function () {
    return "up and working, checkout the <a href='" . env("APP_URL") . "/swagger' target='_blank'>swagger</a> documentation" .
        " or <a href='" . env("APP_URL") . "/horizon-management' target='_blank'>horizon</a>";
});
