<?php

use App\Models\Game;
use App\Models\Team;
use App\Models\User;

it('forbids a coach from viewing another team\'s match', function () {

    $coach = User::factory()->create();
    Team::factory()->create(['user_id' => $coach->id]);

    $otherTeam = Team::factory()->create();
    $otherGame = Game::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($coach);

    Livewire::test('admin.show_match', [
        'id' => $otherGame->uuid,
    ])->assertForbidden();
});

it('allows a coach to view their own team\'s match', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $this->actingAs($coach);

    Livewire::test('admin.show_match', [
        'id' => $game->uuid,
    ])->assertOk();
});
