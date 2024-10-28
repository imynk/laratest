<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserapiController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('users/search', [UserapiController::class, 'search']);

Route::get('user', [UserapiController::class, 'index']);