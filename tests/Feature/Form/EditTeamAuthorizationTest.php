<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Livewire\Livewire;

it('allows a coach to update their team settings', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
        'name' => 'Ancien nom',
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.settings.team-settings')
        ->set('form.name', 'Nouveau nom')
        ->set('form.ville', $team->ville)
        ->set('form.division', $team->division)
        ->call('updateTeam');

    $this->assertDatabaseHas('team', [
        'id' => $team->id,
        'name' => 'Nouveau nom',
    ]);
});

it('prevents a player from updating their team settings', function () {

    $player = User::factory()->create();

    $team = Team::factory()->create(['name' => 'Ancien nom']);

    Player::factory()->create([
        'team_id' => $team->id,
        'user_id' => $player->id,
    ]);

    $this->actingAs($player);

    Livewire::test('admin.settings.team-settings')
        ->set('form.name', 'Nom pirate')
        ->set('form.ville', $team->ville)
        ->set('form.division', $team->division)
        ->call('updateTeam')
        ->assertForbidden();

    $this->assertDatabaseHas('team', [
        'id' => $team->id,
        'name' => 'Ancien nom',
    ]);
});
