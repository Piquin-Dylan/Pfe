<?php


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
    $response->assertSee(__('Inscription'));
});



test('new users can register', function () {

    Livewire::test('form.register')
        ->set('form.firstName', 'Dylan')
        ->set('form.lastName', 'Piquin')
        ->set('form.email', 'dylan@test.com')
        ->set('form.password', 'password123')
        ->call('save');

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'firstName' => 'Dylan',
        'lastName' => 'Piquin',
        'email' => 'dylan@test.com',
    ]);

    expect(
        User::where('email', 'dylan@test.com')->exists()
    )->toBeTrue();
});

use Illuminate\Support\Facades\Hash;

test('password is hashed', function () {

    Livewire::test('form.register')
        ->set('form.firstName', 'Dylan')
        ->set('form.lastName', 'Piquin')
        ->set('form.email', 'dylan@test.com')
        ->set('form.password', 'password123')
        ->call('save');

    $user = User::where('email', 'dylan@test.com')->first();

    expect(
        Hash::check('password123', $user->password)
    )->toBeTrue();
});
