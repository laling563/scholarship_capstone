<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('sport_type')->nullable()->after('type');
            $table->string('skill_level')->nullable()->after('sport_type');
            $table->string('income_bracket')->nullable()->after('skill_level');
            $table->string('dependency_status')->nullable()->after('income_bracket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn(['sport_type', 'skill_level', 'income_bracket', 'dependency_status']);
        });
    }
};
