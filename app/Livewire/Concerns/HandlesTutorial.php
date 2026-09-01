<?php

namespace App\Livewire\Concerns;

use App\Models\Tutorial;
use Illuminate\Support\Facades\Auth;

trait HandlesTutorial
{
    public bool $showTutorial = true;

    protected function initializeTutorial(string $tutorialName, string $startEvent): void
    {
        if (Auth::user()->tutorial()->where('tutorial_name', $tutorialName)->exists()) {
            $this->showTutorial = false;

            return;
        }

        $this->showTutorial = true;

        Tutorial::create([
            'user_id' => Auth::id(),
            'tutorial_name' => $tutorialName,
            'seen' => true,
        ]);

        $this->dispatch($startEvent);
    }
}
