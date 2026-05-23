<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tutorial_name',
        'seen',
    ];

    public $timestamps = false;

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
