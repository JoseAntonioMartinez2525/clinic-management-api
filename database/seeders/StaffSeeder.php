<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;
use App\Models\Role; // This line might not be strictly necessary if Role isn't directly used in the seeder, but it doesn't hurt.

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $receptionistUser = User::where('email', 'receptionist@clinic.com')->first();

        if ($receptionistUser) {
            Staff::firstOrCreate(
                ['user_id' => $receptionistUser->id],
                [
                    'first_name' => 'Jane',
                    'last_name' => 'Roe',
                    'role_title' => 'Receptionist', // Changed 'position' to 'role_title'
                    'phone_number' => '+526121234567',
                    // 'hire_date' field does not exist in the staff table, so it should be removed.
                ]
            );
        }
        // Add more staff members if needed
    }
}