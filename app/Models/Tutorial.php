<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tutorial_name',
        'seen',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
