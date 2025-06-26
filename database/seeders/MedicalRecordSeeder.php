<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment; // If medical record is tied to an appointment

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $doctor = Doctor::first();
        $appointment = Appointment::first(); // Assuming a medical record can be linked to an appointment

        if ($patient && $doctor) {
            MedicalRecord::firstOrCreate(
                ['patient_id' => $patient->id, 'doctor_id' => $doctor->id, 'record_date' => now()->toDateString()],
                [
                    'diagnosis' => 'Gripe común',
                    'treatment' => 'Reposo y medicación.',
                    'notes' => 'Paciente presentó fiebre y tos. Se recomienda abundante líquido.',
                    'appointment_id' => $appointment ? $appointment->id : null, // Link to appointment if exists
                ]
            );
        }
        // Add more medical records
    }
}