<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient; // Necesario para la validación exists
use App\Models\Doctor;  // Necesario para la validación exists
use App\Models\Service; // Necesario para la validación exists
use Illuminate\Http\Request;
use App\Http\Resources\AppointmentResource; // Asegúrate de crear este recurso

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera todas las citas. Para una aplicación real, podrías necesitar
        // eager loading de las relaciones (patient, doctor, service) para mostrar los nombres directamente,
        // pero para los IDs en el frontend es suficiente con el ID.
        // Si quieres incluir los nombres en la respuesta de la API, modificarías así:
        $appointments = Appointment::with(['patient', 'doctor', 'service'])->get();

        // Retorna la colección de citas usando el recurso AppointmentResource
        return AppointmentResource::collection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date|after_or_equal:now', // La cita no puede ser en el pasado
            'end_time' => 'required|date|after:start_time', // La hora de fin debe ser después de la de inicio
            'status' => 'required|string|in:scheduled,confirmed,completed,cancelled,no-show', // Estados válidos
            'notes' => 'nullable|string',
        ]);

        // Opcional: Validación adicional para evitar solapamiento de citas para el mismo doctor
        $existingAppointment = Appointment::where('doctor_id', $validatedData['doctor_id'])
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']])
                    ->orWhere(function ($q) use ($validatedData) {
                        $q->where('start_time', '<', $validatedData['start_time'])
                            ->where('end_time', '>', $validatedData['end_time']);
                    });
            })
            ->first();

        if ($existingAppointment) {
            return response()->json(['message' => 'El doctor ya tiene una cita programada en este horario.'], 409); // Conflict
        }

        // Crear una nueva cita
        $appointment = Appointment::create($validatedData);

        // Retornar la cita creada usando el recurso AppointmentResource
        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Cargar las relaciones para mostrarlas en el recurso si es necesario
        $appointment->load(['patient', 'doctor', 'service']);
        // Retornar la cita específica usando el recurso AppointmentResource
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Validar los datos de entrada para la actualización
        $validatedData = $request->validate([
            'patient_id' => 'sometimes|required|exists:patients,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'service_id' => 'sometimes|required|exists:services,id',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
            'status' => 'sometimes|required|string|in:scheduled,confirmed,completed,cancelled,no-show',
            'notes' => 'nullable|string',
        ]);

        // Opcional: Validación adicional para evitar solapamiento de citas para el mismo doctor
        $existingAppointment = Appointment::where('doctor_id', $validatedData['doctor_id'] ?? $appointment->doctor_id)
            ->where('id', '!=', $appointment->id) // Excluir la cita actual
            ->where(function ($query) use ($validatedData, $appointment) {
                $startTime = $validatedData['start_time'] ?? $appointment->start_time;
                $endTime = $validatedData['end_time'] ?? $appointment->end_time;

                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                    });
            })
            ->first();

        if ($existingAppointment) {
            return response()->json(['message' => 'El doctor ya tiene otra cita programada en este horario.'], 409); // Conflict
        }

        // Actualizar la cita
        $appointment->update($validatedData);

        // Retornar la cita actualizada usando el recurso AppointmentResource
        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // Eliminar la cita
        $appointment->delete();

        // Retornar una respuesta vacía
        return response()->noContent();
    }
}