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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            // Foreign key to the users table, linking the doctor's profile to their login account.
            // It's constrained, meaning a doctor must have a corresponding user account.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('specialty'); // e.g., 'General Practitioner', 'Pediatrician', 'Dermatologist'
            $table->string('license_number')->unique(); // RFC or other professional license number, unique to each doctor
            $table->string('phone_number')->nullable(); // Doctor's direct contact phone
            $table->string('clinic_address')->nullable(); // Address of their primary clinic/office
            $table->text('about_me')->nullable(); // A description about the doctor (similar to Doctoralia profiles)
            $table->string('professional_title')->nullable(); // e.g., 'Dr.', 'Dra.', 'Lic.'
            $table->string('consultation_price')->nullable(); // Optional: default consultation price
            $table->boolean('offers_teleconsultation')->default(false); // Does the doctor offer online consultations?
            // You might add a field for profile picture URL, or a relationship to an 'attachments' table for more media.

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};