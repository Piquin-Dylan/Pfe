<?php

use App\Models\Team;
use App\Models\Train;
use App\Models\User;

test('training page is accessible', function () {

    $coach = User::factory()->create();

    Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $this->actingAs($coach);

    visit('/train')
        ->assertSee('Entraînement');
});
test('training details page is accessible', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $train = Train::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $this->actingAs($coach);

    visit('/train/' . $train->id)
        ->assertSee('Entraînement');
});
