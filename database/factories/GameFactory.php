<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::class,
            'user_id' => User::class,
            'date_match' => fake()->dateTimeBetween('now', '+3 months'),
            'address' => fake()->address,
            'hours' => fake()->time('H:i'),
            'name_away' => fake()->company() . ' FC',
            'photo_away' => 'photos/logo_club.png',
        ];
    }
}
