<?php

use Illuminate\Support\Facades\Route;

/**
 * !!!
 * Prefix "web-api"
 * !!!
 * */

Route
    ::get('profile', \App\Http\Controllers\Web\Api\ProfileController::class)
    ->name('web-api.profile')
;

Route
    ::get('categories', \App\Http\Controllers\Web\Api\CategoriesController::class)
    ->name('web-api.categories')
;
