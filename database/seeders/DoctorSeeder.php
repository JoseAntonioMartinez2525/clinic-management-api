<?php

namespace Database\Seeders;

use App\Models\Doctor; // Ya estaba
use App\Models\User;   // Ya estaba
use App\Models\Role;   // <-- ¡Añade esta línea!
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- ¡Añade esta línea!

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el ID del usuario doctor que creamos
        $doctorUser = User::where('email', 'doctor@clinic.com')->first();

        // Crear un doctor vinculado al usuario doctor
        if ($doctorUser) {
            Doctor::firstOrCreate(
                ['license_number' => 'LIC-123456'], // Un campo único para el doctor
                [
                    'user_id' => $doctorUser->id,
                    'first_name' => 'Maria',
                    'last_name' => 'Fernandez',
                    'specialty' => 'Pediatría',
                    'license_number' => 'LIC-123456', // Asegúrate de que este campo está aquí para la creación
                    'phone_number' => '5566778899',
                    'clinic_address' => 'Clínica Central, Ofna. 101',
                    'about_me' => 'Especialista en salud infantil con más de 10 años de experiencia.',
                    'professional_title' => 'Dra.',
                    'consultation_price' => 850.00,
                    'offers_teleconsultation' => true,
                ]
            );
        }

        // O, mejor aún, crea otro usuario de tipo 'doctor' y vincúlalo.
        $anotherDoctorUser = User::firstOrCreate(
            ['email' => 'doctor2@clinic.com'],
            [
                'name' => 'Dr. Garcia',
                'password' => Hash::make('password'),
                'role_id' => Role::where('name', 'doctor')->first()->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        if ($anotherDoctorUser) {
            Doctor::firstOrCreate(
                ['license_number' => 'LIC-789012'],
                [
                    'user_id' => $anotherDoctorUser->id,
                    'first_name' => 'Carlos',
                    'last_name' => 'Garcia',
                    'specialty' => 'Dermatología',
                    'license_number' => 'LIC-789012', // Asegúrate de que este campo está aquí para la creación
                    'phone_number' => '5511002233',
                    'clinic_address' => 'Centro Médico del Sol, Suite 205',
                    'about_me' => 'Experto en enfermedades de la piel y cuidado estético.',
                    'professional_title' => 'Dr.',
                    'consultation_price' => 1200.00,
                    'offers_teleconsultation' => false,
                ]
            );
        }
    }
}