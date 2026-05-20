<?php

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
    $response->assertSee(__('Inscription'));
});


use App\Models\User;

test('new users can register', function () {
    $response = $this->post(route('register'), [
        'firstName' => 'Dylan',
        'lastName' => 'Piquin',
        'email' => 'dylan@test.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/hub');

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'firstName' => 'Dylan',
        'lastName' => 'Piquin',
        'email' => 'dylan@test.com',
    ]);

    $user = User::where('email', 'dylan@test.com')->first();

    expect($user)->not->toBeNull();
});
