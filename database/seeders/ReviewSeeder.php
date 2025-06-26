<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Appointment;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $patientUser = User::where('email', 'patient@clinic.com')->first();
        $doctorUser = User::where('email', 'doctor@clinic.com')->first();
        $appointment = Appointment::first();

        if ($patientUser && $doctorUser && $appointment) {
            Review::firstOrCreate(
                [
                    'appointment_id' => $appointment->id,
                    'reviewer_id' => $patientUser->id,
                    'reviewed_user_id' => $doctorUser->id,
                ],
                [
                    'rating' => 5,
                    'comments' => 'Excelente atención del Dr. Smith!', // Changed 'comment' to 'comments'
                    // Removed 'review_date' as it's not a column in the migration
                ]
            );
        }
        // Add more review records
    }
}