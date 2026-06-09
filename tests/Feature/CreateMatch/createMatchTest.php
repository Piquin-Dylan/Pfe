<?php

use App\Models\Player;
use App\Models\Team;
use App\Notifications\NewMatchNotification;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use App\Models\User;

it('validates required fields', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('admin.create_event')
        ->call('save')
        ->assertHasErrors([
            'form.date',
            'form.place',
            'form.hours',
            'form.name_away',
            'form.photo_away',
        ]);
});



it('dispatches events after match creation', function () {

    Storage::fake('public');

    $user = User::factory()->create();

    Team::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test('admin.create_event')
        ->set('form.date', '2026-06-15')
        ->set('form.place', 'Liège')
        ->set('form.hours', '18:00')
        ->set('form.name_away', 'Anderlecht')
        ->set('form.photo_away', UploadedFile::fake()->image('team.jpg'))
        ->call('save')
        ->assertDispatched('refresh-calendar')
        ->assertDispatched('match-created');
});



it('creates a game', function () {

    Storage::fake('public');

    $user = User::factory()->create();

    Team::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test('admin.create_event')
        ->set('form.date', '2026-06-15')
        ->set('form.place', 'Liège')
        ->set('form.hours', '18:00')
        ->set('form.name_away', 'Anderlecht')
        ->set('form.photo_away', UploadedFile::fake()->image('team.jpg'))
        ->call('save');

    $this->assertDatabaseHas('matches', [
        'user_id' => $user->id,
        'date_match' => '2026-06-15',
        'address' => 'Liège',
        'hours' => '18:00',
        'name_away' => 'Anderlecht',
    ]);
});



it('sends notification to players', function () {

    Notification::fake();
    Storage::fake('public');

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

    Livewire::test('admin.create_event')
        ->set('form.date', '2026-06-15')
        ->set('form.place', 'Liège')
        ->set('form.hours', '18:00')
        ->set('form.name_away', 'Anderlecht')
        ->set('form.photo_away', UploadedFile::fake()->image('team.jpg'))
        ->call('save');

    Notification::assertSentTo(
        $playerUser,
        NewMatchNotification::class
    );
});
it('prevents players from creating a match', function () {

    $player = User::factory()->create();

    Player::factory()->create([
        'user_id' => $player->id,
    ]);

    $this->actingAs($player);

    Livewire::test('admin.create_event')
        ->call('save');

    $this->assertDatabaseCount('matches', 0);
});
