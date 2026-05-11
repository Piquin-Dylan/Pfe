<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    protected $table = "matches";

    protected $fillable = [
        'team_id',
        'user_id',
        'date_match',
        'address',
        'hours',
        'name_home',
        'name_away',
        'photo_home',
        'photo_away',
    ];

    // ️ un  match appartient à une équipe
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    //  Le match est créé par un user (coach)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //  Les joueurs qui participent au match (many-to-many)
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'player_game', 'match_id', 'player_id')->withPivot('status');
    }
}
