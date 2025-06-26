<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient; // Importar los modelos necesarios
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos IDs de pacientes, doctores y servicios
        $patient1 = Patient::where('email', 'patient@clinic.com')->first();
        $patient2 = Patient::where('email', 'john.smith@example.com')->first();

        $doctor1 = Doctor::where('license_number', 'LIC-123456')->first();
        $doctor2 = Doctor::where('license_number', 'LIC-789012')->first();

        $service1 = Service::where('name', 'Consulta General')->first();
        $service2 = Service::where('name', 'Teleconsulta')->first();

        // Asegurarse de que los registros existen antes de crear citas
        if ($patient1 && $doctor1 && $service1) {
            Appointment::firstOrCreate(
                [ // Campos para buscar si ya existe la cita
                    'patient_id' => $patient1->id,
                    'doctor_id' => $doctor1->id,
                    'start_time' => '2025-07-01 10:00:00', // Fecha y hora futura
                ],
                [ // Campos para crear si no existe
                    'service_id' => $service1->id,
                    'end_time' => '2025-07-01 10:30:00',
                    'status' => 'scheduled',
                    'notes' => 'Paciente con chequeo de rutina.',
                ]
            );
        }

        if ($patient2 && $doctor2 && $service2) {
            Appointment::firstOrCreate(
                [
                    'patient_id' => $patient2->id,
                    'doctor_id' => $doctor2->id,
                    'start_time' => '2025-07-01 11:00:00',
                ],
                [
                    'service_id' => $service2->id,
                    'end_time' => '2025-07-01 11:30:00',
                    'status' => 'confirmed',
                    'notes' => 'Consulta virtual para seguimiento dermatológico.',
                ]
            );
        }

        // Si necesitas más citas, puedes añadir más bloques o usar Factory
        // Appointment::factory(5)->create();
    }
}