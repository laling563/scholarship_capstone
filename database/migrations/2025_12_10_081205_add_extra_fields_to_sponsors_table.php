<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->renameColumn('name', 'sponsor_name');
            $table->string('username')->unique()->after('email');
            $table->string('contact_number')->nullable()->after('username');
            $table->text('notes')->nullable()->after('contact_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->renameColumn('sponsor_name', 'name');
            $table->dropColumn(['username', 'contact_number', 'notes']);
        });
    }
};
