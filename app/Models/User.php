<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    // 👨‍🏫 Un user (coach) peut avoir plusieurs équipes
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
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
}
