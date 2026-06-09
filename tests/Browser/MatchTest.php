<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

test('convocation section is accessible', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $game = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $this->actingAs($coach);

    visit('/match/' . $game->id)
        ->assertSee('Enregistrer les convocations');
});
test('away team name is displayed', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $game = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
        'name_away' => 'Anderlecht',
    ]);

    $this->actingAs($coach);

    visit('/match/' . $game->id)
        ->assertSee('Anderlecht');
});
test('team composition section is displayed', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $game = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $this->actingAs($coach);

    visit('/match/' . $game->id)
        ->assertSee('Composition');
});
