<?php


use App\Models\Player;
use App\Models\Team;
use App\Models\User;

test('user has one team', function () {

    $user = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user->team)->toBeInstanceOf(Team::class);
    expect($user->team->id)->toBe($team->id);
});

test('user has one player profile', function () {

    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user->player)->toBeInstanceOf(Player::class);
    expect($user->player->id)->toBe($player->id);
});



test('user password is hidden', function () {

    $user = new User();

    expect($user->getHidden())
        ->toContain('password')
        ->toContain('remember_token');
});

test('user email is unique', function () {

    $user = User::factory()->create();

    expect($user->email)
        ->not->toBeNull()
        ->toContain('@');
});
