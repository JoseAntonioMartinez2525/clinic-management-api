<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Asegúrate de importar el modelo Role

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define tus roles aquí
        $roles = [
            ['name' => 'admin', 'description' => 'Administrador del sistema con acceso completo.'],
            ['name' => 'doctor', 'description' => 'Médico que atiende consultas y gestiona historiales.'],
            ['name' => 'patient', 'description' => 'Paciente que puede agendar citas y ver su historial.'],
            ['name' => 'receptionist', 'description' => 'Personal administrativo de recepción.'],
            // Puedes añadir más roles si es necesario, por ejemplo, 'nurse', 'manager', etc.
        ];

        // Recorre el array y crea cada rol si no existe ya
        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']], // Busca por el nombre
                $roleData                      // Si no lo encuentra, crea con todos los datos
            );
        }

        // O, si sabes que la tabla estará vacía o quieres sobrescribir, puedes usar:
        // Role::truncate(); // Vacía la tabla de roles si quieres reiniciar siempre
        // foreach ($roles as $roleData) {
        //     Role::create($roleData);
        // }
    }
}