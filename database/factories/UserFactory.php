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

            'image' => $faker->unique()->randomElement([
                'photos/hazard.webp',
                'photos/lukaku.jpg',
                'photos/raskin.png',
                'photos/kdb.png',
                'photos/ngoy.jpg',
                'photos/theate.jpg',
                'photos/meunier.jpg',
                'photos/theate.jpg',
                'photos/courtois.jpg',
                'photos/tros.jpg',
                'photos/cast.jpg',
                'photos/wit.jpg',
                'photos/onana.jpg',
                'photos/van.jpg',
                'photos/mechele.jpg',
                'photos/tiel.jpg',
                'photos/seys.jpg',
                'photos/dec.jpg',
                'photos/de.jpg',
                'photos/onana.jpg',
            ]),
        ];
    }
}
