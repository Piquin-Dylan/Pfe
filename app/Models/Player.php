<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $table = "players";

    protected $fillable = [
        'team_id',
        'user_id',
        'name',
        'firstName',
        'position',
        'maillot',
    ];

    //  Le joueur appartient à une équipe
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    //  Le joueur appartient  à un user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //  Le joueur peut participer  à plusieurs matchs
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    public function trains(): BelongsToMany
    {
        return $this->belongsToMany(Train::class);
    }
}
