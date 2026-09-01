<?php

namespace App\Actions\Match;

use App\Models\Game;
use App\Models\MatchComposition;

class SaveComposition
{
    public function handle(Game $match, array $playerPositions): void
    {
        MatchComposition::where('match_id', $match->id)->delete();

        foreach ($playerPositions as $position => $playerId) {
            MatchComposition::create([
                'match_id' => $match->id,
                'player_id' => $playerId,
                'position' => $position,
            ]);
        }
    }
}
