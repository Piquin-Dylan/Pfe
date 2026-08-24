<?php

use App\Models\Game;
use App\Models\Team;
use App\Models\User;

it('forbids a coach from updating another team\'s match score', function () {

    $coach = User::factory()->create();
    Team::factory()->create(['user_id' => $coach->id]);

    $otherTeam = Team::factory()->create();
    $otherGame = Game::factory()->create(['team_id' => $otherTeam->id, 'score_home' => null, 'score_away' => null]);

    $this->actingAs($coach);

    Livewire::test('admin.match')
        ->set('score_home', 3)
        ->set('score_away', 1)
        ->call('updateScore', $otherGame->id)
        ->assertForbidden();

    $this->assertDatabaseHas('matches', [
        'id' => $otherGame->id,
        'score_home' => null,
        'score_away' => null,
    ]);
});

it('allows a coach to update their own team\'s match score', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $this->actingAs($coach);

    Livewire::test('admin.match')
        ->set('score_home', 2)
        ->set('score_away', 0)
        ->call('updateScore', $game->id);

    $this->assertDatabaseHas('matches', [
        'id' => $game->id,
        'score_home' => 2,
        'score_away' => 0,
    ]);
});
