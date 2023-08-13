<?php

use App\Http\Controllers\patientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [patientController::class, 'home']);
Route::get('/dashboard', [patientController::class , 'dashbord'] );
Route::get('/signup', [patientController::class , 'showSignUp']);


Route::post('/signup',[patientController::class , 'signUp']);
