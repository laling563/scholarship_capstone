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
        Schema::create('application_forms', function (Blueprint $table) {
            $table->id('applicationform_id');
            $table->unsignedBigInteger('scholarship_id');
            $table->unsignedBigInteger('student_id'); // Student ID foreign key
            
            // Personal Information
            $table->date('date_of_birth');
            $table->string('civil_status');
            $table->string('place_of_birth');
            $table->string('religion')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // In cm
            $table->decimal('weight', 5, 2)->nullable(); // In kg
            
            // Address Information
            $table->text('home_address');
            $table->text('contact_address')->nullable();
            $table->text('boarding_address')->nullable();
            $table->string('landlord_landlady')->nullable();
            
            // Educational Background
            $table->string('high_school_graduated');
            $table->year('high_school_year_graduated');
            $table->text('special_skills')->nullable();
            $table->string('curriculum_year')->nullable();
            
            // Father's Information
            $table->string('father_first_name');
            $table->string('father_middle_name')->nullable();
            $table->string('father_last_name');
            $table->string('father_occupation')->nullable();
            $table->decimal('father_monthly_income', 12, 2)->nullable();
            $table->string('father_educational_attainment')->nullable();
            $table->string('father_school_graduated')->nullable();
            $table->year('father_year_graduated')->nullable();
            
            // Mother's Information
            $table->string('mother_first_name');
            $table->string('mother_middle_name')->nullable();
            $table->string('mother_last_name');
            $table->string('mother_occupation')->nullable();
            $table->decimal('mother_monthly_income', 12, 2)->nullable();
            $table->string('mother_educational_attainment')->nullable();
            $table->string('mother_school_graduated')->nullable();
            $table->year('mother_year_graduated')->nullable();
            
            // Family Information
            $table->integer('number_of_brothers')->default(0);
            $table->integer('number_of_sisters')->default(0);
            $table->decimal('total_monthly_income', 12, 2)->nullable();
            
            // Application Status
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->date('submission_date');
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Allows for soft deletion

            // Foreign key constraints
            $table->foreign('scholarship_id')->references('scholarship_id')->on('scholarships')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            
            // Add a unique constraint to prevent duplicate applications
            $table->unique(['scholarship_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_forms');
    }
};
