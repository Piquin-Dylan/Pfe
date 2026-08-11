<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;

it('keeps player attendance status visible after clicking a position filter', function () {

    $coach = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $coach->id]);

    $train = Train::factory()->create(['team_id' => $team->id]);

    $player = Player::factory()->create([
        'team_id' => $team->id,
        'position' => 'DC',
    ]);

    $train->players()->attach($player->id, ['status' => 'present']);

    $this->actingAs($coach);

    Livewire::test('admin.team', [
        'playersWithStatus' => $train->players()->get(),
    ])
        ->assertSee('present')
        ->call('filter', 'defenseur')
        ->assertSee('present');
});
