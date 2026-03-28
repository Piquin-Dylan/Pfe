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

Route::get('/logout', function () {
    return view('client.hub');
});

Route::middleware('auth')->group(function () {
    Route::get('/create', function () {
        return view('client.create_team');
    });
    Route::get('/join', function () {
        return view('client.join_team');
    });
    Route::get('/profile', function () {
        return view('client.form_profile');
    });
    Route::get('/hub', function () {
        return view('client.hub');
    });
});
