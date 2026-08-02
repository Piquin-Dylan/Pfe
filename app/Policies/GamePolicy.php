<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    public function view(User $user, Game $game): bool
    {
        return $game->team_id === $user->team?->id
            || $game->team_id === $user->player?->team_id;
    }

    public function delete(User $user, Game $game): bool
    {
        return $game->team_id === $user->team?->id;
    }
}
