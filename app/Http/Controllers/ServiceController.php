<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource; // Asegúrate de crear este recurso

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera todos los servicios
        $services = Service::all();
        // Retorna la colección de servicios usando el recurso ServiceResource
        return ServiceResource::collection($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Crear un nuevo servicio
        $service = Service::create($validatedData);

        // Retornar el servicio creado usando el recurso ServiceResource
        return new ServiceResource($service);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // Retornar el servicio específico usando el recurso ServiceResource
        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Validar los datos de entrada para la actualización
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:services,name,' . $service->id, // Excluir el propio ID del servicio
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Actualizar el servicio
        $service->update($validatedData);

        // Retornar el servicio actualizado usando el recurso ServiceResource
        return new ServiceResource($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Eliminar el servicio
        $service->delete();

        // Retornar una respuesta vacía
        return response()->noContent();
    }
}