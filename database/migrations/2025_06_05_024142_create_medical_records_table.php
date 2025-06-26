<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            // Foreign key to appointments (if a medical record is directly tied to an appointment)
            // Make sure 'appointments' table migration runs BEFORE this one.
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('cascade');

            // Foreign key to patients
            // Make sure 'patients' table migration runs BEFORE this one.
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // Foreign key to doctors (who created/managed this record)
            // Make sure 'doctors' table migration runs BEFORE this one.
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');

            $table->date('record_date'); // Date of the medical record/consultation
            $table->text('diagnosis'); // Diagnosis made by the doctor
            $table->text('treatment')->nullable(); // Treatment plan
            $table->text('notes')->nullable(); // Additional notes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
