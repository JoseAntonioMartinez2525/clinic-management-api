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
        Schema::create('appointment_reminders', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key to appointments table.
            // Ensure 'appointments' table migration runs BEFORE this one.
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');

            $table->string('type'); // Type of reminder (e.g., 'SMS', 'Email', 'WhatsApp', 'Push Notification')
            $table->dateTime('send_time'); // When the reminder is scheduled to be sent
            $table->string('status')->default('pending'); // Status of the reminder (e.g., 'pending', 'sent', 'failed')

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_reminders');
    }
};