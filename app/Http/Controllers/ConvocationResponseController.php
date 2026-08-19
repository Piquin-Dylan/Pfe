<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Notifications\ParticipationResponseNotification;

class ConvocationResponseController extends Controller
{
    public function __invoke(Game $match, Player $player, string $status)
    {
        $match->players()->updateExistingPivot($player->id, [
            'status' => $status,
        ]);

        $match->team->user->notify(
            new ParticipationResponseNotification('match', $status, $player->id, $match)
        );

        return view('client.convocation-response', [
            'status' => $status,
            'match' => $match,
        ]);
    }
}
