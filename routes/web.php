<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('components.client.accueil');
});
Route::get('/inscription', function () {
    return view('components.client.inscription');
});
Route::get('/connexion', function () {
    return view('components.client.connexion');
});
