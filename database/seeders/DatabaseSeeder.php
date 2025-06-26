<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,          // Primero roles
            UserSeeder::class,          // Luego usuarios (dependen de roles)
            PatientSeeder::class,       // Pacientes (pueden depender de usuarios)
            DoctorSeeder::class,        // Doctores (dependen de usuarios)
            StaffSeeder::class,         // Personal (depende de usuarios)
            ServiceSeeder::class,       // Servicios
            MedicationSeeder::class,    // Medicamentos (si es un catálogo, sin dependencias)
            AppointmentSeeder::class,   // Citas (dependen de pacientes, doctores, servicios)
            AppointmentReminderSeeder::class, // Recordatorios (dependen de citas)
            MedicalRecordSeeder::class, // Historiales (dependen de pacientes, doctores, citas)
            PaymentSeeder::class,       // Pagos (dependen de citas, pacientes)
            ReviewSeeder::class,        // Reseñas (dependen de usuarios, citas)
        ]);
    }
}