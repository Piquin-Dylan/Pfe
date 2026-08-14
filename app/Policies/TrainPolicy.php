<?php

namespace App\Policies;

use App\Models\Train;
use App\Models\User;

class TrainPolicy
{
    public function view(User $user, Train $train): bool
    {
        return $train->team_id === $user->currentTeam()?->id;
    }

    public function delete(User $user, Train $train): bool
    {
        return $train->team_id === $user->team?->id;
    }
}
