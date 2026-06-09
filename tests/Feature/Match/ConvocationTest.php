<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

it('creates match convocation with pending status', function () {

    Notification::fake();

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $game = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $player = Player::factory()->create([
        'team_id' => $team->id,
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.show_match', [
        'id' => $game->id,
    ])
        ->set('checked', [$player->id])
        ->call('saveConvocation');

    $this->assertDatabaseHas('player_game', [
        'match_id' => $game->id,
        'player_id' => $player->id,
        'status' => 'en attente',
    ]);
});
it('adds a player during a second convocation', function () {

    Notification::fake();

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $game = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $player = Player::factory()->create([
        'team_id' => $team->id,
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.show_match', [
        'id' => $game->id,
    ])
        ->set('checkedSecondConvocation', [$player->id])
        ->call('saveSecondConvocation');

    $this->assertDatabaseHas('player_game', [
        'match_id' => $game->id,
        'player_id' => $player->id,
        'status' => 'en attente',
    ]);
});
