<?php

use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\Player;
use App\Models\Train;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('client.accueil');
})->name('accueil');
Route::get('/register', function () {
    return view('client/auth.inscription');
})->name('register');
Route::get('/login', function () {
    return view('client/auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('client/auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function (string $token) {
    return view('client/auth.reset-password', [
        'token' => $token,
        'email' => request('email', ''),
    ]);
})->name('password.reset');

Route::get('/convocation/{match}/{player}/{status}', function (Game $match, Player $player, string $status) {
    return view('client.convocation-response', [
        'match' => $match,
        'player' => $player,
        'status' => $status,
    ]);
})
    ->name('convocation.respond')
    ->middleware('signed')
    ->where('status', 'present|absent');

Route::get('/convocation/train/{train}/{player}/{status}', function (Train $train, Player $player, string $status) {
    return view('client.convocation-response', [
        'train' => $train,
        'player' => $player,
        'status' => $status,
    ]);
})
    ->name('convocation.train.respond')
    ->middleware('signed')
    ->where('status', 'present|absent');

Route::middleware('auth')->group(function () {

    Route::get('/create', function () {
        return view('client/auth.create_team');
    })->name('create');

    Route::get('/profile', function () {
        return view('client/auth.form_profile');
    })->name('profile');

    Route::get('/hub', function () {
        return view('client.hub');
    })->name('hub');

    Route::get('/update', function () {
        return view('client/auth/update_profile');
    });

    Route::get('/calendar/events', function () {

        $teamId = Auth::user()->currentTeam()?->id;

        $games = Game::where('team_id', $teamId)->get()->map(function ($game) {
            return [
                'title' => '⚽ Match',
                'start' => $game->date_match,
                'color' => '#ef4444',
                'address' => $game->address,
                'hours' => $game->hours,
                'id' => $game->uuid,
                'type' => 'game',
            ];
        });

        $trains = Train::where('team_id', $teamId)->get()->map(function ($train) {
            return [
                'title' => '🏃 Entraînement',
                'start' => $train->date_train,
                'color' => '#22c55e',
                'address' => $train->address,
                'hours_start' => $train->hours_start,
                'hours_end' => $train->hours_end,
                'id' => $train->uuid,
                'type' => 'train',
            ];
        });

        $events = $games->concat($trains)->values();

        return response()->json($events);
    });

    Route::middleware('has_team_or_player')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/team', function () {
            return view('admin.team');
        })->name('team');

        Route::get('/calendrier', function () {
            return view('admin.calendrier');
        })->name('calendrier');

        Route::get('/message', function () {
            return view('admin.message');
        })->name('message');

        Route::get('/match', function () {
            return view('admin.match');
        })->name('match');

        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');

        Route::get('/statistiques', function () {
            return view('admin.statistiques');
        })->name('statistiques');

        Route::get('/match/{id}', function ($id) {

            if (Auth::user()->player) {
                return view('client.show_match', [
                    'id' => $id,
                ]);
            }

            return view('admin.show_match', [
                'id' => $id,
            ]);
        });

        Route::get('/match/{id}/live', function ($id) {

            if (Auth::user()->player) {
                return redirect('/match');
            }

            return view('admin.match_live', [
                'id' => $id,
            ]);
        });

        Route::get('/train', function () {
            return view('admin.train');
        })->name('train');

        Route::get('/train/{id}', function ($id) {

            if (Auth::user()->player) {
                return view('client.show_train', [
                    'id' => $id,
                ]);
            }

            return view('admin.show_train', [
                'id' => $id
            ]);
        });

    });

});
