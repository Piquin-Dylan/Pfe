<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id');
            $table->foreignId('match_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_player');
    }
};
