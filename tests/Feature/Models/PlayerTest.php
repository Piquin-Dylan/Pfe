<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\User;

test('player belongs to a user', function () {

    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($player->user)->toBeInstanceOf(User::class);
    expect($player->user->id)->toBe($user->id);
});

test('player belongs to a team', function () {

    $team = Team::factory()->create();

    $player = Player::factory()->create([
        'team_id' => $team->id,
    ]);

    expect($player->team)->toBeInstanceOf(Team::class);
    expect($player->team->id)->toBe($team->id);
});

test('player contains expected fillable attributes', function () {

    $player = new Player();

    expect($player->getFillable())
        ->toContain('team_id')
        ->toContain('user_id')
        ->toContain('name')
        ->toContain('firstName')
        ->toContain('position')
        ->toContain('maillot');
});

test('player has a valid shirt number', function () {

    $player = Player::factory()->create();

    expect($player->maillot)->toBeInt();
    expect($player->maillot)->toBeGreaterThanOrEqual(1);
    expect($player->maillot)->toBeLessThanOrEqual(99);
});

test('player has a valid position', function () {

    $positions = [
        'G',
        'DD',
        'DC',
        'DG',
        'MD',
        'MC',
        'MG',
        'AD',
        'AG',
        'BU',
    ];

    $player = Player::factory()->create();

    expect($positions)->toContain($player->position);
});
