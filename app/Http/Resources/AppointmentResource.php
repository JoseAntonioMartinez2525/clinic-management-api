<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'service_id' => $this->service_id,
            'start_time' => $this->start_time, // Laravel casteará esto a un objeto Carbon
            'end_time' => $this->end_time,     // Laravel casteará esto a un objeto Carbon
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Incluir las relaciones si han sido cargadas (eager loaded)
            'patient' => new PatientResource($this->whenLoaded('patient')), // Asume que tienes PatientResource
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),   // Asume que tienes DoctorResource
            'service' => new ServiceResource($this->whenLoaded('service')), // Asume que tienes ServiceResource
        ];
    }
}