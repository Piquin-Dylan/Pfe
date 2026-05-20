<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'firstName' => fake()->firstName(),
            'lastName'  => fake()->lastName(),
            'email'     => fake()->unique()->safeEmail(),
            'password'  => Hash::make('password'),
            'image'     => null,
        ];
    }
}
