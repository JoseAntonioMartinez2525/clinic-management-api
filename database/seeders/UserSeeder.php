<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role; // Importar el modelo Role
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Para hashear contraseñas

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los IDs de los roles
        $adminRole = Role::where('name', 'admin')->first();
        $doctorRole = Role::where('name', 'doctor')->first();
        $patientRole = Role::where('name', 'patient')->first();
        $receptionistRole = Role::where('name', 'receptionist')->first();

        // Crear usuario administrador
        User::firstOrCreate(
            ['email' => 'admin@clinic.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Contraseña simple para desarrollo
                'role_id' => $adminRole->id ?? null, // Asignar el ID del rol de admin
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario doctor
        User::firstOrCreate(
            ['email' => 'doctor@clinic.com'],
            [
                'name' => 'Dr. Smith',
                'password' => Hash::make('password'),
                'role_id' => $doctorRole->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario paciente
        User::firstOrCreate(
            ['email' => 'patient@clinic.com'],
            [
                'name' => 'Patient Doe',
                'password' => Hash::make('password'),
                'role_id' => $patientRole->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario recepcionista
        User::firstOrCreate(
            ['email' => 'receptionist@clinic.com'],
            [
                'name' => 'Receptionist User',
                'password' => Hash::make('password'),
                'role_id' => $receptionistRole->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // Puedes crear más usuarios con factory si lo deseas, pero para roles específicos, firstOrCreate es mejor.
        // User::factory(5)->create(); // Crea 5 usuarios genéricos si es necesario
    }
}