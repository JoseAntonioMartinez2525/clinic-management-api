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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key to patients table
            // Ensure 'patients' table migration runs BEFORE this one.
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // Foreign key to appointments table (nullable if a payment isn't tied to a specific appointment, e.g., upfront payment)
            // Ensure 'appointments' table migration runs BEFORE this one.
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');

            $table->decimal('amount', 10, 2); // Amount of the payment (e.g., up to 99,999,999.99)
            $table->string('payment_method'); // e.g., 'Cash', 'Card', 'Bank Transfer', 'Online'
            $table->dateTime('payment_date'); // Date and time when the payment was made
            $table->string('status')->default('paid'); // e.g., 'paid', 'pending', 'refunded', 'failed'

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};