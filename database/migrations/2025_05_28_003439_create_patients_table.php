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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Foreign key to the users table.
            // This links the patient's profile to their login credentials in the 'users' table.
            // It's nullable because a patient might exist in the system (e.g., added by staff)
            // before they create an online account and become a 'user'.
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable(); // Date of birth might be optional initially
            $table->string('gender')->nullable(); // e.g., 'Male', 'Female', 'Other'
            $table->string('phone_number')->unique(); // Phone number should likely be unique for contact
            $table->string('email')->unique()->nullable(); // Patient email might be optional or unique if provided
            $table->string('address')->nullable(); // Address can be stored here

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};