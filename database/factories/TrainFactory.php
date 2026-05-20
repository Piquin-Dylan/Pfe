<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Train;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainFactory extends Factory
{
    protected $model = Train::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::class,
            'user_id' => User::class,
            'date_train' => fake()->date(),
            'address' => fake()->address,
            'hours_start' => fake()->time('H:i'),
            'hours_end' => fake()->time('H:i'),
        ];
    }
}
