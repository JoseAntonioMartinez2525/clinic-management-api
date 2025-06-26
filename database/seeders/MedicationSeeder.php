<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = [
            ['name' => 'Paracetamol 500mg', 'description' => 'Analgésico y antipirético.', 'dosage_form' => 'Tableta'],
            ['name' => 'Amoxicilina 250mg/5ml', 'description' => 'Antibiótico de amplio espectro.', 'dosage_form' => 'Suspensión oral'],
            ['name' => 'Ibuprofeno 400mg', 'description' => 'Antiinflamatorio no esteroideo (AINE).', 'dosage_form' => 'Cápsula'],
        ];

        foreach ($medications as $medData) {
            Medication::firstOrCreate(['name' => $medData['name']], $medData);
        }
    }
}