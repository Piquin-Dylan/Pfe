<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
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

        return [
            'team_id'   => Team::factory(),
            'user_id'   => User::factory(),
            'name'      => fake()->lastName(),
            'firstName' => fake()->firstName(),
            'position'  => fake()->randomElement($positions),
            'maillot'   => fake()->unique()->numberBetween(1, 99),
        ];
    }
}
