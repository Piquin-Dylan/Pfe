<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('player_train', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id');
            $table->foreignId('train_id');
            $table->string('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_train');
    }
};
