<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_skills', function (Blueprint $table) {
            // Add proficiency column (0-100 for skill level)
            $table->tinyInteger('proficiency')->default(0)->after('skill_id')->comment('Skill proficiency level (0-100)');
        });
    }

    public function down(): void
    {
        Schema::table('user_skills', function (Blueprint $table) {
            // Drop proficiency column
            $table->dropColumn('proficiency');

            
        });
    }
};
