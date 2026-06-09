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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($coachNumber = 1; $coachNumber <= 5; $coachNumber++) {

            $coach = User::create([
                'firstName' => 'Coach',
                'lastName' => $coachNumber,
                'email' => "coach{$coachNumber}@test.com",
                'password' => Hash::make('password'),
                'image' => 'photos/person.png',
            ]);

            $team = Team::factory()->create([
                'user_id' => $coach->id,
            ]);

            $trains = Train::factory()
                ->count(5)
                ->create([
                    'team_id' => $team->id,
                    'user_id' => $coach->id,
                ]);

            $games = Game::factory()
                ->count(5)
                ->create([
                    'team_id' => $team->id,
                    'user_id' => $coach->id,
                ]);

            for ($playerNumber = 1; $playerNumber <= 15; $playerNumber++) {

                $user = User::create([
                    'firstName' => 'Joueur',
                    'lastName' => $playerNumber,
                    'email' => "coach{$coachNumber}_joueur{$playerNumber}@test.com",
                    'password' => Hash::make('password'),
                    'image' => 'photos/person.png',
                ]);

                $player = Player::factory()->create([
                    'user_id' => $user->id,
                    'team_id' => $team->id,
                ]);

                foreach ($trains as $train) {
                    $player->trains()->attach($train->id, [
                        'status' => fake()->randomElement([
                            'present',
                            'absent',
                            'en attente',
                        ]),
                    ]);
                }

                foreach ($games as $game) {
                    $player->games()->attach($game->id, [
                        'status' => fake()->randomElement([
                            'present',
                            'absent',
                            'en attente',
                        ]),
                    ]);
                }

                $user->notify(
                    new NewTrainNotification($trains->first())
                );

                $user->notify(
                    new NewMatchNotification($games->first())
                );
            }
        }
    }
}
