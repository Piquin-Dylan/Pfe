<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Train extends Model
{
    use HasFactory;

    protected $table = "trains";

    protected static function booted(): void
    {
        static::creating(function (Train $train) {
            $train->uuid ??= (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected $fillable = [
        'team_id',
        'user_id',
        'date_train',
        'address',
        'hours_start',
        'hours_end',
    ];

    //  Un entraînement appartient à une équipe
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    //  Un entraînement est créé par un user (coach)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot('status');
    }
}
