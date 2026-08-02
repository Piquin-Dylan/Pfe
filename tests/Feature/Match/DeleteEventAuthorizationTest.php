<?php

use App\Models\Game;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;

it('forbids a coach from deleting another team\'s match', function () {

    $coach = User::factory()->create();
    Team::factory()->create(['user_id' => $coach->id]);

    $otherTeam = Team::factory()->create();
    $otherGame = Game::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($coach);

    Livewire::test('admin.calendar')
        ->call('deleteEvent', $otherGame->uuid, 'game')
        ->assertForbidden();

    $this->assertDatabaseHas('matches', ['id' => $otherGame->id]);
});

it('allows a coach to delete their own team\'s match', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $game = Game::factory()->create(['team_id' => $team->id]);

    $this->actingAs($coach);

    Livewire::test('admin.calendar')
        ->call('deleteEvent', $game->uuid, 'game');

    $this->assertDatabaseMissing('matches', ['id' => $game->id]);
});

it('forbids a coach from deleting another team\'s training', function () {

    $coach = User::factory()->create();
    Team::factory()->create(['user_id' => $coach->id]);

    $otherTeam = Team::factory()->create();
    $otherTrain = Train::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($coach);

    Livewire::test('admin.calendar')
        ->call('deleteEvent', $otherTrain->uuid, 'train')
        ->assertForbidden();

    $this->assertDatabaseHas('trains', ['id' => $otherTrain->id]);
});
