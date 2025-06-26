<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment; // Example: to fetch appointment counts
use App\Models\Patient;     // Example: to fetch patient counts
use App\Models\Doctor;      // Example: to fetch doctor counts

class DashboardController extends Controller
{
    /**
     * Get data for the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Example: Fetch some aggregate data for the dashboard
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();

        // You can customize this to return any data your dashboard needs
        return response()->json([
            'message' => 'Dashboard data fetched successfully.',
            'data' => [
                'total_appointments' => $totalAppointments,
                'pending_appointments' => $pendingAppointments,
                'total_patients' => $totalPatients,
                'total_doctors' => $totalDoctors,
                // Add more data points as your dashboard grows
            ],
        ]);
    }
}