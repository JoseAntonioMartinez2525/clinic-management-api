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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->string('name')->unique(); // Name of the service (e.g., 'Inyección', 'Canalización', 'Ultrasonido', 'Radiografía', 'Consulta General')
            $table->text('description')->nullable(); // Optional: A brief description of the service
            $table->decimal('price', 8, 2); // Price of the service (e.g., 8 digits total, 2 after decimal)
            $table->integer('duration_minutes')->nullable(); // Optional: Estimated duration of the service in minutes (useful for scheduling)
            $table->boolean('is_active')->default(true); // To easily enable/disable services without deleting them

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};