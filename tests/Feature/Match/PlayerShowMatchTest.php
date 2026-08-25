<?php

use App\Models\Game;
use App\Models\MatchComposition;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use App\Notifications\ParticipationResponseNotification;

it('allows a player to view their own team\'s match', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $player = Player::factory()->create(['team_id' => $team->id]);

    $this->actingAs($player->user);

    Livewire::test('client.show_match', [
        'id' => $game->uuid,
    ])->assertOk();
});

it('forbids a player from viewing another team\'s match', function () {

    $team = Team::factory()->create();
    $otherTeam = Team::factory()->create();
    $otherGame = Game::factory()->create(['team_id' => $otherTeam->id]);

    $player = Player::factory()->create(['team_id' => $team->id]);

    $this->actingAs($player->user);

    Livewire::test('client.show_match', [
        'id' => $otherGame->uuid,
    ])->assertForbidden();
});

it('lets a convoked player respond present and notifies the coach', function () {

    Notification::fake();

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $player = Player::factory()->create(['team_id' => $team->id]);
    $game->players()->attach($player->id, ['status' => 'en attente']);

    $this->actingAs($player->user);

    Livewire::test('client.show_match', [
        'id' => $game->uuid,
    ])
        ->assertSet('myStatus', 'en attente')
        ->call('respondConvocation', 'present')
        ->assertSet('myStatus', 'present');

    $this->assertDatabaseHas('player_game', [
        'match_id' => $game->id,
        'player_id' => $player->id,
        'status' => 'present',
    ]);

    Notification::assertSentTo($coach, ParticipationResponseNotification::class);
});

it('ignores a response from a player who was never convoked', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $player = Player::factory()->create(['team_id' => $team->id]);

    $this->actingAs($player->user);

    Livewire::test('client.show_match', [
        'id' => $game->uuid,
    ])
        ->assertSet('myStatus', null)
        ->call('respondConvocation', 'present')
        ->assertSet('myStatus', null);

    $this->assertDatabaseMissing('player_game', [
        'match_id' => $game->id,
        'player_id' => $player->id,
    ]);
});

it('shows the player their assigned position in the composition', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $player = Player::factory()->create(['team_id' => $team->id]);
    $game->players()->attach($player->id, ['status' => 'present']);

    MatchComposition::create([
        'match_id' => $game->id,
        'player_id' => $player->id,
        'position' => 'gardien',
    ]);

    $this->actingAs($player->user);

    Livewire::test('client.show_match', [
        'id' => $game->uuid,
    ])->assertSet('myPosition', 'gardien');
});
