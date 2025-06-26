<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Resources\DoctorResource; // Asegúrate de crear este recurso

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera todos los doctores. Puedes añadir paginación si la lista es larga.
        $doctors = Doctor::all();
        // Retorna la colección de doctores usando el recurso DoctorResource
        return DoctorResource::collection($doctors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // Un doctor debe tener un user_id asociado
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:doctors,license_number',
            'phone_number' => 'nullable|string|max:20',
            'clinic_address' => 'nullable|string|max:255',
            'about_me' => 'nullable|string',
            'professional_title' => 'nullable|string|max:255',
            'consultation_price' => 'nullable|numeric|min:0',
            'offers_teleconsultation' => 'boolean',
        ]);

        // Crear un nuevo doctor
        $doctor = Doctor::create($validatedData);

        // Retornar el doctor creado usando el recurso DoctorResource con un código de estado 201 (Created)
        return new DoctorResource($doctor);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        // Retornar el doctor específico usando el recurso DoctorResource
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        // Validar los datos de entrada para la actualización
        $validatedData = $request->validate([
            // user_id generalmente no se cambia después de la creación
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'specialty' => 'sometimes|required|string|max:255',
            'license_number' => 'sometimes|required|string|max:255|unique:doctors,license_number,' . $doctor->id, // Excluir el propio ID del doctor
            'phone_number' => 'nullable|string|max:20',
            'clinic_address' => 'nullable|string|max:255',
            'about_me' => 'nullable|string',
            'professional_title' => 'nullable|string|max:255',
            'consultation_price' => 'nullable|numeric|min:0',
            'offers_teleconsultation' => 'boolean',
        ]);

        // Actualizar el doctor
        $doctor->update($validatedData);

        // Retornar el doctor actualizado usando el recurso DoctorResource
        return new DoctorResource($doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // Eliminar el doctor
        $doctor->delete();

        // Retornar una respuesta vacía con código de estado 204 (No Content)
        return response()->noContent();
    }
}
