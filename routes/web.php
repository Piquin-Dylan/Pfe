<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.accueil');
});
Route::get('/inscription', function () {
    return view('client.inscription');
});
Route::get('/connexion', function () {
    return view('client.connexion');
});
Route::get('/create', function () {
    return view('client.creation_equipe');
});
