<?php


use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Livewire\Livewire;

test('user can join a team with a valid code', function () {

    $user = User::factory()->create();

    $team = Team::factory()->create([
        'code' => 'ABC123',
    ]);

    $this->actingAs($user);

    Livewire::test('form.form_profile')
        ->set('form.name', 'Dupont')
        ->set('form.firstName', 'Jean')
        ->set('form.poste', 'BU')
        ->set('form.maillot', '10')
        ->set('form.code', 'ABC123')
        ->call('save');

    $this->assertDatabaseHas('players', [
        'user_id' => $user->id,
        'team_id' => $team->id,
        'name' => 'Dupont',
        'firstName' => 'Jean',
        'position' => 'BU',
        'maillot' => 10,
    ]);
});

test('joined player belongs to the correct team', function () {

    $user = User::factory()->create();

    $team = Team::factory()->create([
        'code' => 'ABC123',
    ]);

    $this->actingAs($user);

    Livewire::test('form.form_profile')
        ->set('form.name', 'Dupont')
        ->set('form.firstName', 'Jean')
        ->set('form.poste', 'BU')
        ->set('form.maillot', '10')
        ->set('form.code', 'ABC123')
        ->call('save');

    $player = Player::first();

    expect($player)->not->toBeNull();
    expect($player->team_id)->toBe($team->id);
});

test('user cannot join a team with an invalid code', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('form.form_profile')
        ->set('form.name', 'Dupont')
        ->set('form.firstName', 'Jean')
        ->set('form.poste', 'BU')
        ->set('form.maillot', '10')
        ->set('form.code', 'FAUXCODE')
        ->call('save');

    expect(Player::count())->toBe(0);
});
