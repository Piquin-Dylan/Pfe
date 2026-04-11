<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Self_;

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



    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
