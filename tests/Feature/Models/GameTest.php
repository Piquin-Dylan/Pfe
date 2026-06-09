<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

test('game belongs to a team', function () {

    $team = Team::factory()->create();

    $game = Game::factory()->create([
        'team_id' => $team->id,
    ]);

    expect($game->team)->toBeInstanceOf(Team::class);
    expect($game->team->id)->toBe($team->id);
});

test('game belongs to a user', function () {

    $user = User::factory()->create();

    $game = Game::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($game->user)->toBeInstanceOf(User::class);
    expect($game->user->id)->toBe($user->id);
});

test('game can have players', function () {

    $game = Game::factory()->create();

    $players = Player::factory()->count(3)->create();

    $game->players()->attach(
        $players->pluck('id')->toArray(),
        ['status' => 'present']
    );

    expect($game->players)->toHaveCount(3);
});

test('game contains expected fillable attributes', function () {

    $game = new Game();

    expect($game->getFillable())
        ->toContain('team_id')
        ->toContain('user_id')
        ->toContain('date_match')
        ->toContain('address')
        ->toContain('hours')
        ->toContain('name_away')
        ->toContain('photo_away')
        ->toContain('score_home')
        ->toContain('score_away');
});

test('game stores scores', function () {

    $game = Game::factory()->create([
        'score_home' => 3,
        'score_away' => 1,
    ]);

    expect($game->score_home)->toBe(3);
    expect($game->score_away)->toBe(1);
});
