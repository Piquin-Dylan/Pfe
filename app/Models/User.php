<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'user_id',
        'firstName',
        'lastName',
        'email',
        'password',
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




}
