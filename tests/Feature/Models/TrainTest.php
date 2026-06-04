<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;

test('train belongs to a team', function () {

    $team = Team::factory()->create();

    $train = Train::factory()->create([
        'team_id' => $team->id,
    ]);

    expect($train->team)->toBeInstanceOf(Team::class);
    expect($train->team->id)->toBe($team->id);
});

test('train belongs to a user', function () {

    $user = User::factory()->create();

    $train = Train::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($train->user)->toBeInstanceOf(User::class);
    expect($train->user->id)->toBe($user->id);
});

test('train can have players', function () {

    $train = Train::factory()->create();

    $players = Player::factory()->count(3)->create();

    $train->players()->attach(
        $players->pluck('id')->toArray(),
        ['status' => 'present']
    );

    expect($train->players)->toHaveCount(3);
});

test('train contains expected fillable attributes', function () {

    $train = new Train();

    expect($train->getFillable())
        ->toContain('team_id')
        ->toContain('user_id')
        ->toContain('date_train')
        ->toContain('address')
        ->toContain('hours_start')
        ->toContain('hours_end');
});

test('train stores start and end hours', function () {

    $train = Train::factory()->create([
        'hours_start' => '18:00',
        'hours_end' => '20:00',
    ]);

    expect($train->hours_start)->toBe('18:00');
    expect($train->hours_end)->toBe('20:00');
});
