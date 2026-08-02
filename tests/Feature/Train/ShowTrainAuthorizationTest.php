<?php

use App\Models\Team;
use App\Models\Train;
use App\Models\User;

it('forbids a coach from viewing another team\'s training', function () {

    $coach = User::factory()->create();
    Team::factory()->create(['user_id' => $coach->id]);

    $otherTeam = Team::factory()->create();
    $otherTrain = Train::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($coach);

    Livewire::test('admin.show_train', [
        'id' => $otherTrain->id,
    ])->assertForbidden();
});

it('allows a coach to view their own team\'s training', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);
    $train = Train::factory()->create(['team_id' => $team->id]);

    $this->actingAs($coach);

    Livewire::test('admin.show_train', [
        'id' => $train->id,
    ])->assertOk();
});
