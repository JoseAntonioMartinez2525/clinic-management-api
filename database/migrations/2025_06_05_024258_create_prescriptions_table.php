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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key to the medical_records table.
            // This links a prescription to a specific medical consultation/record.
            $table->foreignId('medical_record_id')->constrained('medical_records')->onDelete('cascade');

            // Foreign key to the medications table.
            // This links a prescription to a specific medication from your catalog.
            $table->foreignId('medication_id')->constrained('medications')->onDelete('cascade');

            $table->string('dosage'); // Dosis (e.g., '500 mg', '10 ml', '1 Tableta')
            $table->string('frequency'); // Frecuencia (e.g., 'Cada 8 horas', '2 veces al día', 'Antes de dormir')
            $table->string('duration'); // Duración del tratamiento (e.g., '7 días', 'Hasta terminar', 'Por 2 semanas')
            $table->text('notes')->nullable(); // Optional: Additional instructions or notes for the patient/pharmacist

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
