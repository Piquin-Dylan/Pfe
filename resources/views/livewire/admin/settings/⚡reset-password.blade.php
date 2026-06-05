<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (! Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Le mot de passe actuel est incorrect.');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset([
            'current_password',
            'password',
            'password_confirmation',
        ]);

        session()->flash('success', 'Mot de passe modifié avec succès.');
    }
};
?>

<div class="space-y-6">

    @if (session()->has('success'))
        <div class="p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <x-form.input
        label_name="Mot de passe actuel"
        for_label="current_password"
        placeholder="********"
        type="password"
        id="current_password"
        name="current_password"
        wire:model="current_password">
    </x-form.input>

    @error('current_password')
    <p class="text-sm text-red-500">{{ $message }}</p>
    @enderror

    <x-form.input
        label_name="Nouveau mot de passe"
        for_label="password"
        placeholder="********"
        type="password"
        id="password"
        name="password"
        wire:model="password">
    </x-form.input>

    @error('password')
    <p class="text-sm text-red-500">{{ $message }}</p>
    @enderror

    <x-form.input
        label_name="Confirmer le mot de passe"
        for_label="password_confirmation"
        placeholder="********"
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        wire:model="password_confirmation">
    </x-form.input>

    <div class="flex justify-center">
        <button
            wire:click="updatePassword"
            class="btn-form">
            Modifier le mot de passe
        </button>
    </div>

</div>
