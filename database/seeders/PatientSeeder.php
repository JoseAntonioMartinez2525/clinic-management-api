<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User; // Importar el modelo User
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el ID del usuario paciente que creamos
        $patientUser = User::where('email', 'patient@clinic.com')->first();

        // Crear un paciente vinculado a un usuario (si el usuario paciente existe)
        Patient::firstOrCreate(
            ['email' => 'patient@clinic.com'], // Usa un campo único para buscar
            [
                'user_id' => $patientUser->id ?? null, // Asigna el user_id si el usuario existe
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'date_of_birth' => '1990-05-15',
                'gender' => 'female',
                'phone_number' => '5511223344',
                'address' => 'Calle Falsa 123, Ciudad Ejemplo',
            ]
        );

        // Crear otro paciente no vinculado a un usuario (solo para el perfil de paciente)
        Patient::firstOrCreate(
            ['phone_number' => '5599887766'], // Usa un campo único
            [
                'user_id' => null, // Este paciente no tiene una cuenta de usuario asociada
                'first_name' => 'John',
                'last_name' => 'Smith',
                'date_of_birth' => '1985-11-22',
                'gender' => 'male',
                'email' => 'john.smith@example.com',
                'address' => 'Avenida Siempre Viva 456, Otra Ciudad',
            ]
        );

        // Puedes usar Factory para crear más pacientes de forma masiva
        // Patient::factory(10)->create();
    }
}