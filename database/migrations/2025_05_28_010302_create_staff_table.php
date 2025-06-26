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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            // Foreign key to the users table, linking staff's profile to their login account.
            // constrained means a staff member must have a corresponding user account.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');
            // 'role' field to distinguish between different staff types directly in this table.
            // Using a string for simplicity, but could be an enum or foreign key to a 'staff_roles' table
            // if more granular roles are needed within the 'staff' category itself.
            $table->string('role_title')->nullable(); // Renamed to role_title to avoid confusion with the 'roles' table used for general users. E.g., 'Receptionist', 'Nurse', 'Manager'.
            $table->string('phone_number')->nullable();
            $table->string('email')->unique()->nullable(); // Staff email, unique if provided.
            // You might also add other staff-specific details like 'employment_start_date', 'department', etc.

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
