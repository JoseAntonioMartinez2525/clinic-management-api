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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key to patients table
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // Foreign key to doctors table
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');

            // Foreign key to services table
            // This is for the primary service of the appointment (e.g., 'General Consultation')
            $table->foreignId('service_id')->constrained('services')->onDelete('restrict'); // Or 'cascade' if deleting a service should delete related appointments

            $table->dateTime('start_time'); // When the appointment starts
            $table->dateTime('end_time');   // When the appointment is expected to end
            $table->string('status')->default('scheduled'); // e.g., 'scheduled', 'confirmed', 'completed', 'canceled', 'no-show'
            $table->text('notes')->nullable(); // Any specific notes for the appointment

            $table->timestamps(); // created_at and updated_at

            // Add unique constraint to prevent double booking for the same doctor at the same time
            // You might need more complex logic for overlapping appointments depending on specifics
            $table->unique(['doctor_id', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};