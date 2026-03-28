<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.accueil');
});
Route::get('/inscription', function () {
    return view('client.inscription');
});
Route::get('/login', function () {
    return view('client.login');
})->name('login');
Route::get('/create', function () {
    return view('client.create_team');
})->middleware('auth');
Route::get('/join', function () {
    return view('client.join_team');
});
Route::get('/profile', function () {
    return view('client.form_profile');
})->middleware('auth');
Route::get('/hub', function () {
    return view('client.hub');
})->middleware('auth');
Route::get('/logout', function () {
    return view('client.hub');
});
