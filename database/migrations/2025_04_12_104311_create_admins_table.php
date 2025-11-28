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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('faculty_id', 100)->unique();  // Faculty ID (unique)
            $table->string('fname');    // First name
            $table->string('lname');    // Last name
            $table->string('email')->unique();  // Email for login
            $table->string('password'); // Hashed password
            $table->enum('role', ['super_admin', 'admin'])->default('admin');  // Role (admin, super_admin)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
