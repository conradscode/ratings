<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropColumn(['like_active']);
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->boolean('like_active')->default(true);
        });
    }
};
