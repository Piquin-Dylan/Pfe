<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;

test('team belongs to a user', function () {

    $user = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($team->user)->toBeInstanceOf(User::class);
    expect($team->user->id)->toBe($user->id);
});

test('team has many players', function () {

    $team = Team::factory()->create();

    Player::factory()->count(3)->create([
        'team_id' => $team->id,
    ]);

    expect($team->players)->toHaveCount(3);
});

test('team has many games', function () {

    $team = Team::factory()->create();

    Game::factory()->count(2)->create([
        'team_id' => $team->id,
    ]);

    expect($team->games)->toHaveCount(2);
});

test('team has many trainings', function () {

    $team = Team::factory()->create();

    Train::factory()->count(4)->create([
        'team_id' => $team->id,
    ]);

    expect($team->trains)->toHaveCount(4);
});

test('team contains expected fillable attributes', function () {

    $team = new Team();

    expect($team->getFillable())
        ->toContain('user_id')
        ->toContain('name')
        ->toContain('ville')
        ->toContain('division')
        ->toContain('code')
        ->toContain('logo');
});

test('team code is generated', function () {

    $team = Team::factory()->create();

    expect($team->code)
        ->not->toBeNull()
        ->not->toBeEmpty();
});
