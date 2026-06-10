<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;
use App\Notifications\NewMatchConvocation;
use App\Notifications\NewMatchNotification;
use App\Notifications\NewTrainNotification;
use App\Notifications\ParticipationResponseNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'G',
            'DD',
            'DC',
            'DG',
            'MD',
            'MC',
            'MG',
            'AD',
            'AG',
            'BU',
        ];

        for ($coachNumber = 1; $coachNumber <= 25; $coachNumber++) {

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

            $players = collect();
            foreach ($positions as $index => $position) {

                $firstName = fake()->firstName();
                $lastName = fake()->lastName();

                $user = User::create([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => "joueur" . ($index + 1) . "_team{$coachNumber}@test.com",
                    'password' => Hash::make('password'),
                    'image' => 'photos/person.png',
                ]);

                $player = Player::create([
                    'team_id' => $team->id,
                    'user_id' => $user->id,
                    'name' => $lastName,
                    'firstName' => $firstName,
                    'position' => $position,
                    'maillot' => $index + 1,
                ]);

                $players->push($player);
            }
            $playerNumber = 11;

            while ($players->count() < 20) {

                $firstName = fake()->firstName();
                $lastName = fake()->lastName();

                $user = User::create([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => "joueur{$playerNumber}_team{$coachNumber}@test.com",
                    'password' => Hash::make('password'),
                    'image' => 'photos/person.png',
                ]);

                $player = Player::create([
                    'team_id' => $team->id,
                    'user_id' => $user->id,
                    'name' => $lastName,
                    'firstName' => $firstName,
                    'position' => fake()->randomElement($positions),
                    'maillot' => fake()->numberBetween(11, 99),
                ]);

                $players->push($player);
                $playerNumber++;
            }

            $trains = Train::factory()
                ->count(3)
                ->create([
                    'team_id' => $team->id,
                    'user_id' => $coach->id,
                ]);

            foreach ($trains as $train) {

                $presentPlayers = $players->random(15);

                $remaining = $players->diff($presentPlayers);

                $absentPlayers = $remaining->random(3);

                $pendingPlayers = $remaining->diff($absentPlayers);

                foreach ($players as $player) {

                    if ($presentPlayers->contains($player)) {
                        $status = 'present';
                    } elseif ($absentPlayers->contains($player)) {
                        $status = 'absent';
                    } else {
                        $status = 'en attente';
                    }

                    $player->trains()->attach($train->id, [
                        'status' => $status,
                    ]);

                    if ($status !== 'en attente') {
                        $coach->notify(
                            new ParticipationResponseNotification(
                                'train',
                                $status,
                                $player->id,
                                $train
                            )
                        );
                    }
                }
            }

            $matchReady = Game::factory()->create([
                'team_id' => $team->id,
                'user_id' => $coach->id,
                'score_home' => 2,
                'score_away' => 1,
            ]);

            $calledPlayers = $players->random(18);

            foreach ($calledPlayers as $index => $player) {

                $status = match (true) {
                    $index < 11 => 'present',
                    $index < 15 => 'absent',
                    default => 'en attente',
                };

                $player->games()->attach($matchReady->id, [
                    'status' => $status,
                ]);

                if ($status !== 'en attente') {
                    $coach->notify(
                        new ParticipationResponseNotification(
                            'match',
                            $status,
                            $player->id,
                            $matchReady
                        )
                    );
                }

                $player->user->notify(
                    new NewMatchConvocation($matchReady)
                );
            }

            $matchWaiting = Game::factory()->create([
                'team_id' => $team->id,
                'user_id' => $coach->id,
            ]);


            foreach ($players as $player) {

                foreach ($trains as $train) {

                    $player->user->notify(
                        new NewTrainNotification($train)
                    );
                }

                $player->user->notify(
                    new NewMatchNotification($matchReady)
                );
            }
        }
    }
}
