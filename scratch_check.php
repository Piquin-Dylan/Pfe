<?php

echo App\Models\User::count() . " users, " . App\Models\Team::count() . " teams, " . App\Models\Player::count() . " players, " . App\Models\Game::count() . " games, " . App\Models\Train::count() . " trains" . PHP_EOL;

$users = App\Models\User::whereHas('team')->take(3)->get(['id', 'email', 'firstName']);

foreach ($users as $u) {
    echo $u->id . ' ' . $u->email . ' ' . $u->firstName . PHP_EOL;
}
