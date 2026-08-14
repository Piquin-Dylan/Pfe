<?php

namespace App\Models;

use App\Models\Concerns\HasMediaUrl;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasMediaUrl;

    protected $table = 'users';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'image',
        'rounds',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }

    //  Un user est associé a un joueur player
    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);

    }
    public function trains(): HasMany
    {
        return $this->hasMany(Train::class);

    }

    public function tutorial(): HasMany
    {
        return $this->hasMany(Tutorial::class);
    }

    public function currentTeam(): ?Team
    {
        return $this->team ?? $this->player?->team;
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveMediaUrl($this->image));
    }
}
