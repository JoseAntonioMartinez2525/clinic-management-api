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
        Schema::create('medications', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->string('name')->unique(); // Nombre del medicamento (e.g., 'Paracetamol', 'Amoxicilina')
            $table->string('generic_name')->nullable(); // Nombre genérico del medicamento, si aplica
            $table->string('brand_name')->nullable(); // Nombre de marca, si es diferente al genérico
            $table->text('description')->nullable(); // Descripción, uso, efectos secundarios
            $table->string('dosage_form')->nullable(); // Forma de dosificación (e.g., 'Tableta', 'Cápsula', 'Jarabe', 'Inyección')
            $table->string('strength')->nullable(); // Concentración del medicamento (e.g., '500 mg', '250 mg/5 ml')
            $table->string('unit')->nullable(); // Unidad de medida (e.g., 'mg', 'ml')
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};