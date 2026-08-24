<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('user can login', function () {

    User::create([
        'firstName' => 'Dylan',
        'lastName' => 'Piquin',
        'email' => 'dylan@test.com',
        'password' => Hash::make('password123'),
    ]);

    Livewire::test('form.login')
        ->set('form.email', 'dylan@test.com')
        ->set('form.password', 'password123')
        ->call('save');

    $this->assertAuthenticated();

    expect(auth()->user()->email)
        ->toBe('dylan@test.com');
});

test('user cannot login with wrong password', function () {

    User::create([
        'firstName' => 'Dylan',
        'lastName' => 'Piquin',
        'email' => 'dylan@test.com',
        'password' => Hash::make('password123'),
    ]);

    Livewire::test('form.login')
        ->set('form.email', 'dylan@test.com')
        ->set('form.password', 'mauvaismotdepasse')
        ->call('save');

    $this->assertGuest();
});

test('login is throttled after too many failed attempts', function () {

    User::create([
        'firstName' => 'Dylan',
        'lastName' => 'Piquin',
        'email' => 'dylan@test.com',
        'password' => Hash::make('password123'),
    ]);

    $component = Livewire::test('form.login')
        ->set('form.email', 'dylan@test.com')
        ->set('form.password', 'mauvaismotdepasse');

    for ($i = 0; $i < 5; $i++) {
        $component->call('save');
    }

    $this->assertGuest();

    // Même avec le bon mot de passe, la 6e tentative doit rester bloquée par le rate limiting.
    $component->set('form.password', 'password123')
        ->call('save');

    $this->assertGuest();
});

