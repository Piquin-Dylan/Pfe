<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

it('saves a match composition', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $game = Game::factory()->create([
        'team_id' => $team->id,
        'user_id' => $coach->id,
    ]);

    $player = Player::factory()->create([
        'team_id' => $team->id,
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.show_match', [
        'id' => $game->id,
    ])
        ->set('player_position', [
            'gardien' => $player->id,
        ])
        ->call('saveComposition');

    $this->assertDatabaseHas('match_compositions', [
        'match_id' => $game->id,
        'player_id' => $player->id,
        'position' => 'gardien',
    ]);
});
