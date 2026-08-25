<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

it('lets a player reach the match details from the match list', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $player = Player::factory()->create(['team_id' => $team->id]);

    $this->actingAs($player->user);

    Livewire::test('admin.match')
        ->assertSeeHtml('/match/' . $game->uuid);
});

it('lets a coach reach the match details from the match list', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $this->actingAs($coach);

    Livewire::test('admin.match')
        ->assertSeeHtml('/match/' . $game->uuid);
});
