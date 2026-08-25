<?php

use App\Models\Game;
use App\Models\Team;
use App\Models\User;

it('computes club stats from finished matches only', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);

    // Win 3-1
    Game::factory()->create([
        'team_id' => $team->id,
        'date_match' => now()->subDays(3),
        'score_home' => 3,
        'score_away' => 1,
    ]);

    // Draw 2-2
    Game::factory()->create([
        'team_id' => $team->id,
        'date_match' => now()->subDays(2),
        'score_home' => 2,
        'score_away' => 2,
    ]);

    // Loss 0-1
    Game::factory()->create([
        'team_id' => $team->id,
        'date_match' => now()->subDay(),
        'score_home' => 0,
        'score_away' => 1,
    ]);

    // Not played yet, should be ignored
    Game::factory()->create([
        'team_id' => $team->id,
        'date_match' => now()->addWeek(),
        'score_home' => null,
        'score_away' => null,
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.statistiques')
        ->assertSet('wins', 1)
        ->assertSet('draws', 1)
        ->assertSet('losses', 1)
        ->assertSet('goalsFor', 5)
        ->assertSet('goalsAgainst', 4)
        ->assertSet('winRate', 33)
        ->assertSet('recentForm', ['D', 'N', 'V']);
});
