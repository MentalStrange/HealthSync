<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('pages/home');
});

Route::get('/dashboard', function () {
    return view('pages/dashboard');
});
