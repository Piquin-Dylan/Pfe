<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('match_compositions', function (Blueprint $table) {
            $table->string('formation')->default('4-4-2')->after('match_id');
        });
    }

    public function down(): void
    {
        Schema::table('match_compositions', function (Blueprint $table) {
            $table->dropColumn('formation');
        });
    }
};
