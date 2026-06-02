<?php


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Team;
use App\Models\User;
use Livewire\Livewire;

test('user can create a team', function () {

    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('form.create_team')
        ->set('form.name', 'Standard')
        ->set('form.ville', 'Liège')
        ->set('form.division', 'Première division')
        ->set('form.logo', UploadedFile::fake()->image('logo.png'))
        ->call('save');

    $this->assertDatabaseHas('team', [
        'user_id' => $user->id,
        'name' => 'Standard',
        'ville' => 'Liège',
        'division' => 'Première division',
    ]);

    expect(
        Team::where('name', 'Standard')->exists()
    )->toBeTrue();
});


test('created team belongs to authenticated user', function () {

    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('form.create_team')
        ->set('form.name', 'Standard')
        ->set('form.ville', 'Liège')
        ->set('form.division', 'Première division')
        ->set('form.logo', UploadedFile::fake()->image('logo.png'))
        ->call('save');

    $team = Team::first();

    expect($team)->not->toBeNull();
    expect($team->user_id)->toBe($user->id);
});
