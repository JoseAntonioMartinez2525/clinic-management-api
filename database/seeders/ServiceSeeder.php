<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::firstOrCreate(
            ['name' => 'Consulta General'],
            [
                'description' => 'Revisión médica de rutina y diagnóstico inicial.',
                'price' => 600.00,
                'duration_minutes' => 30,
                'is_active' => true,
            ]
        );

        Service::firstOrCreate(
            ['name' => 'Inyección'],
            [
                'description' => 'Administración de medicamentos por vía intramuscular o intravenosa.',
                'price' => 150.00,
                'duration_minutes' => 10,
                'is_active' => true,
            ]
        );

        Service::firstOrCreate(
            ['name' => 'Sutura Menor'],
            [
                'description' => 'Cierre de heridas pequeñas con suturas.',
                'price' => 400.00,
                'duration_minutes' => 20,
                'is_active' => true,
            ]
        );

        Service::firstOrCreate(
            ['name' => 'Curación de Heridas'],
            [
                'description' => 'Limpieza y vendaje de heridas.',
                'price' => 250.00,
                'duration_minutes' => 15,
                'is_active' => true,
            ]
        );

        Service::firstOrCreate(
            ['name' => 'Teleconsulta'],
            [
                'description' => 'Consulta médica virtual a través de videollamada.',
                'price' => 700.00,
                'duration_minutes' => 30,
                'is_active' => true,
            ]
        );

        // Service::factory(5)->create(); // Para crear más servicios genéricos
    }
}