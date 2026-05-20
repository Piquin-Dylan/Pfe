<?php

use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\Train;

Route::get('/', function () {
    return view('client.accueil');
})->name('accueil');
Route::get('/register', function () {
    return view('client/auth.inscription');
})->name('register');
Route::get('/login', function () {
    return view('client/auth.login');
})->name('login');

Route::get('/logout', function () {
    return view('client.hub');
})->name('hub');


Route::get('/calendar/events', function () {
    $games = Game::all()->map(function ($game) {
        return [
            'title' => '⚽ ' . 'Match',
            'start' => $game->date_match,
            'color' => '#ef4444',
            'address' => $game->address,
            'hours' => $game->hours,
            'id' => $game->id,
        ];
    });

    $trains = Train::all()->map(function ($train) {
        return [
            'title' => '🏃 Entraînement',
            'start' => $train->date_train,
            'color' => '#22c55e',
            'address' => $train->address,
            'hours_start' => $train->hours_start,
            'hours_end' => $train->hours_end,
            'id' => $train->id,

        ];
    });

    $events = $games->concat($trains)->values();

    return response()->json($events);
});


Route::middleware('auth')->group(function () {
    Route::get('/create', function () {
        return view('client/auth.create_team');
    })->name('create');
    Route::get('/join', function () {
        return view('client/auth.join_team');
    })->name('join');
    Route::get('/profile', function () {
        return view('client/auth.form_profile');
    })->name('profile');
    Route::get('/hub', function () {
        return view('client.hub');
    })->name('hub');
    Route::get('/update', function () {
        return view('client/auth/update_profile');
    });

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/team', function () {
        return view('admin.team');
    })->name('team');
    /* Route::get('/calendar-test', function () {
         return view('calendar-test');
     });*/
    Route::get('/calendrier', function () {
        return view('admin.calendrier');
    })->name('calendrier');
    Route::get('/message', function () {
        return view('admin.message');
    })->name('message');
    Route::get('/match', function () {
        return view('admin.match');
    })->name('match');
    Route::get('/match/{id}', function ($id) {
        if (Auth::user()->player) {
            return redirect('/matchF');
        }

        return view('admin.show_match', [
            'id' => $id,
        ]);
    })->middleware('auth');
    Route::get('/train', function () {
        return view('admin.train');
    })->name('train');
    Route::get('/train/{id}', function ($id) {
        return view('admin.show_train', [
            'id' => $id
        ]);
    });

});




