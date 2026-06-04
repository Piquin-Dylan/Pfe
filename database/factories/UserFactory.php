<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            'password' => Hash::make('password'),

            'image' => 'photos/person.png',
        ];
    }
}
