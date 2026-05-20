<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;
use App\Notifications\NewMatchNotification;
use App\Notifications\NewTrainNotification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $teams = collect();

        $coachUsers = User::factory()->count(2)->create();

        foreach ($coachUsers as $coachUser) {
            $team = Team::factory()->create([
                'user_id' => $coachUser->id,
            ]);

            $teams->push($team);
        }

        foreach ($teams as $team) {
            $train = Train::factory()->create([
                'team_id' => $team->id,
                'user_id' => $team->user_id,
            ]);

            $game = Game::factory()->create([
                'team_id' => $team->id,
                'user_id' => $team->user_id,
            ]);

            $playerUsers = User::factory()->count(18)->create();

            foreach ($playerUsers as $playerUser) {
                $player = Player::factory()->create([
                    'user_id' => $playerUser->id,
                    'team_id' => $team->id,
                ]);

                $player->trains()->attach($train->id, [
                    'status' => 'en attente',
                ]);

                $player->games()->attach($game->id, [
                    'status' => 'present',
                ]);

                $playerUser->notify(new NewTrainNotification($train));
                $playerUser->notify(new NewMatchNotification($game));
            }
        }
    }
}
