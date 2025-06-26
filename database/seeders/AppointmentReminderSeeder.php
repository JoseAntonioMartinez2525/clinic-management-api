<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentReminder;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentReminderSeeder extends Seeder
{
    public function run(): void
    {
        $appointment = Appointment::first();

        if ($appointment) {
            AppointmentReminder::firstOrCreate(
                [
                    'appointment_id' => $appointment->id,
                    'type' => 'Email',
                    'send_time' => Carbon::parse($appointment->start_time)->subHours(24),
                ],
                [
                    'status' => 'pending',
                ]
            );

            AppointmentReminder::firstOrCreate(
                [
                    'appointment_id' => $appointment->id,
                    'type' => 'SMS',
                    'send_time' => Carbon::parse($appointment->start_time)->subHours(2),
                ],
                [
                    'status' => 'pending',
                ]
            );
        }
    }
}