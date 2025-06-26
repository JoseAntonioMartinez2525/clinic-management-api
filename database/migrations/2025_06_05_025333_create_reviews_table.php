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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key to appointments table. A review is typically for a specific appointment.
            // Ensure 'appointments' table migration runs BEFORE this one.
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');

            // Foreign key to users table: The user who is giving the review (e.g., the patient)
            // Ensure 'users' table migration runs BEFORE this one.
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');

            // Foreign key to users table: The user who is being reviewed (e.g., the doctor or staff)
            // Ensure 'users' table migration runs BEFORE this one.
            $table->foreignId('reviewed_user_id')->constrained('users')->onDelete('cascade');

            $table->integer('rating')->nullable(); // Rating (e.g., 1 to 5 stars). Nullable if comments are optional without a rating.
            $table->text('comments')->nullable(); // Text comments/feedback

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};