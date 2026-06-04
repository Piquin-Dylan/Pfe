<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' FC',
            'ville' => fake()->city(),
            'division' => fake()->randomElement([
                'D1',
                'D2',
                'D3',
                'Provinciale 1',
                'Provinciale 2',
            ]),
            'code' => strtoupper(fake()->bothify('???###')),
            'logo' => 'photos/logo.png',
            'user_id' => User::factory(),
        ];
    }
}
