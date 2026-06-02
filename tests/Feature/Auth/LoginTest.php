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

