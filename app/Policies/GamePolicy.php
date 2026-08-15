<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    public function view(User $user, Game $game): bool
    {
        return $game->team_id === $user->currentTeam()?->id;
    }

    public function update(User $user, Game $game): bool
    {
        return $game->team_id === $user->team?->id;
    }

    public function delete(User $user, Game $game): bool
    {
        return $game->team_id === $user->team?->id;
    }
}
