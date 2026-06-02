<?php



it('displays the registration form fields', function () {

    $page = visit('/register');

    $page
        ->assertSee('Inscription')
        ->assertPresent('#firstName')
        ->assertPresent('#lastName')
        ->assertPresent('#email')
        ->assertPresent('#password')
        ->assertPresent('#photo');
});


it('requires a valid email address during registration', function () {

    $page = visit('/register');

    $page
        ->fill('#firstName', 'Dylan')
        ->fill('#lastName', 'Piquin')
        ->fill('#email', 'pas-un-email')
        ->fill('#password', 'password123')
        ->click('Inscription');
});
