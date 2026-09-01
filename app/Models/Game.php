<?php

namespace App\Models;

use App\Models\Concerns\HasMediaUrl;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory, HasMediaUrl;

    protected $table = "matches";

    protected static function booted(): void
    {
        static::creating(function (Game $game) {
            $game->uuid ??= (string) Str::uuid();
        });
    }

        public function getRouteKeyName(): string
        {
            return 'uuid';
        }

    protected $fillable = [
        'team_id',
        'user_id',
        'date_match',
        'address',
        'hours',
        'name_away',
        'photo_away',
        'score_home',
        'score_away'
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

    protected function photoAwayUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveMediaUrl($this->photo_away));
    }
}
