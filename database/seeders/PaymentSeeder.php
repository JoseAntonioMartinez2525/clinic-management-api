<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Patient;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $appointment = Appointment::first();
        $patient = Patient::first();

        if ($appointment && $patient) {
            Payment::firstOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'patient_id' => $patient->id,
                    'amount' => $appointment->service->price,
                    'payment_date' => now(),
                    'payment_method' => 'Credit Card', // Changed 'method' to 'payment_method'
                    'status' => 'completed',
                ]
            );
        }
        // Add more payment records
    }
}