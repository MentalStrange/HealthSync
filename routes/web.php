<?php

use App\Http\Controllers\patientController;
use Illuminate\Support\Facades\Route;
// for all users
Route::get('/', [patientController::class, 'home']);

// guests
Route::group(['middleware' => 'guests'], function () {
    Route::get('/signup', [patientController::class, 'showSignUp']);
    Route::post('/signup', [patientController::class, 'signUp']);
    Route::get('/login', [patientController::class, 'showLogin']);
    Route::post('/login', [patientController::class, 'login']);
});
// user logged in
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [patientController::class, 'dashbord']);
    Route::get('/logout', [patientController::class, 'logout']);
    Route::get('/userData', [patientController::class, 'userData']);
});
