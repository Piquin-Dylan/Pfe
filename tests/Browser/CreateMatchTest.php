<?php

use App\Models\Game;
use App\Models\Team;
use App\Models\User;

test('match page is accessible', function () {

    $coach = User::factory()->create();

    Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $this->actingAs($coach);

    visit('/match')
        ->assertSee('Match');
});
test('away team is displayed on match page', function () {

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
test('convocation button is visible', function () {

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
