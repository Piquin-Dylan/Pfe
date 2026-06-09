<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use App\Models\User;
use App\Notifications\NewTrainNotification;
use Livewire\Livewire;

it('validates required fields', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('admin.create_train')
        ->call('save')
        ->assertHasErrors([
            'form.date',
            'form.places',
            'form.hours_start',
            'form.hours_end',
        ]);
});




it('creates a training', function () {

    $user = User::factory()->create();

    Team::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test('admin.create_train')
        ->set('form.date', '2026-06-15')
        ->set('form.places', 'Liège')
        ->set('form.hours_start', '18:00')
        ->set('form.hours_end', '20:00')
        ->call('save');

    $this->assertDatabaseHas('trains', [
        'user_id' => $user->id,
        'date_train' => '2026-06-15',
        'address' => 'Liège',
        'hours_start' => '18:00',
        'hours_end' => '20:00',
    ]);
});



it('sends notification to players', function () {

    Notification::fake();

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $playerUser = User::factory()->create();

    Player::factory()->create([
        'team_id' => $team->id,
        'user_id' => $playerUser->id,
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.create_train')
        ->set('form.date', '2026-06-15')
        ->set('form.places', 'Liège')
        ->set('form.hours_start', '18:00')
        ->set('form.hours_end', '20:00')
        ->call('save');

    Notification::assertSentTo(
        $playerUser,
        NewTrainNotification::class
    );
});



it('attaches players to training with pending status', function () {

    $coach = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $coach->id,
    ]);

    $player = Player::factory()->create([
        'team_id' => $team->id,
    ]);

    $this->actingAs($coach);

    Livewire::test('admin.create_train')
        ->set('form.date', '2026-06-15')
        ->set('form.places', 'Liège')
        ->set('form.hours_start', '18:00')
        ->set('form.hours_end', '20:00')
        ->call('save');

    $train = Train::first();

    $this->assertDatabaseHas('player_train', [
        'player_id' => $player->id,
        'train_id' => $train->id,
        'status' => 'en attente',
    ]);
});
