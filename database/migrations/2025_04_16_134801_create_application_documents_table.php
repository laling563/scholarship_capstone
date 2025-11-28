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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicationform_id');
            $table->string('document_type'); // e.g., 'certificate_of_enrollment', 'transcript', etc.
            $table->string('file_name');
            $table->string('file_path');
            // $table->string('file_type')->nullable(); // MIME type
            // $table->integer('file_size')->nullable(); // Size in bytes
            // $table->string('status')->default('submitted'); // submitted, verified, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('applicationform_id')
                  ->references('applicationform_id')
                  ->on('application_forms')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};