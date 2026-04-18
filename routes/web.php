<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.accueil');
});
Route::get('/inscription', function () {
    return view('client/auth.inscription');
});
Route::get('/login', function () {
    return view('client/auth.login');
})->name('login');

Route::get('/logout', function () {
    return view('client.hub');
});
Route::get('/dashboard/{id}', function () {
    return view('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/create', function () {
        return view('client/auth.create_team');
    });
    Route::get('/join', function () {
        return view('client/auth.join_team');
    });
    Route::get('/profile', function () {
        return view('client/auth.form_profile');
    });
    Route::get('/hub', function () {
        return view('client.hub');
    });
    Route::get('/update', function () {
        return view('client/auth/update_profile');
    });
});
