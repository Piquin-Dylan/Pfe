<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

it('saves a match composition', function () {

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
        'id' => $game->uuid,
    ])
        ->set('player_position', [
            'gardien' => $player->id,
        ])
        ->call('saveComposition');

    $this->assertDatabaseHas('match_compositions', [
        'match_id' => $game->id,
        'player_id' => $player->id,
        'position' => 'gardien',
        'formation' => '4-4-2',
    ]);
});

it('loads a previous composition, keeping only present players', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $previousGame = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $currentGame = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $presentPlayer = Player::factory()->create(['team_id' => $team->id]);
    $absentPlayer = Player::factory()->create(['team_id' => $team->id]);

    \App\Models\MatchComposition::create([
        'match_id' => $previousGame->id,
        'player_id' => $presentPlayer->id,
        'position' => 'gardien',
        'formation' => '4-3-3',
    ]);

    \App\Models\MatchComposition::create([
        'match_id' => $previousGame->id,
        'player_id' => $absentPlayer->id,
        'position' => 'AG',
        'formation' => '4-3-3',
    ]);

    $currentGame->players()->attach([
        $presentPlayer->id => ['status' => 'present'],
        $absentPlayer->id => ['status' => 'absent'],
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.show_match', [
        'id' => $currentGame->uuid,
    ])
        ->call('loadPreviousComposition', $previousGame->id)
        ->assertSet('match_composition', '4-3-3')
        ->assertSet('player_position', [
            'gardien' => $presentPlayer->id,
        ]);
});
