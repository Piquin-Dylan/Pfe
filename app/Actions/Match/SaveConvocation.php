<?php

namespace App\Actions\Match;

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use App\Notifications\NewMatchConvocation;
use Illuminate\Support\Facades\Notification;

class SaveConvocation
{
    public function handle(Game $match, array $playerIds, bool $append = false): void
    {
        $playersArray = [];

        foreach ($playerIds as $playerId) {
            $playersArray[$playerId] = ['status' => 'en attente'];
        }

        $append
            ? $match->players()->attach($playersArray)
            : $match->players()->sync($playersArray);

        $match->load('players');

        $userIds = Player::whereIn('id', $playerIds)->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();

        Notification::send($users, new NewMatchConvocation($match));
    }
}
