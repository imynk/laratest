<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserapiController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('api/users/search', [UserapiController::class, 'search']);
