<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'user_id',
        'firstName',
        'lastName',
        'email',
        'password',
        'image',
        'rouds',
        'rounds',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function team(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function player(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function Game(): HasMany
    {
        return $this->hasMany(Game::class);
    }


}
