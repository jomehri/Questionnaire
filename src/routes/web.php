<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "up and working, checkout our <a href='" . env("APP_URL") . "/api/documentation' target='_blank'>swagger</a>";
});
