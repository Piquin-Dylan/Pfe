<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('accueil');
});
Route::get('/inscription', function () {
    return view('inscription');
});
