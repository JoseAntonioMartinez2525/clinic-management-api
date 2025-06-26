<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'specialty' => $this->specialty,
            'license_number' => $this->license_number,
            'phone_number' => $this->phone_number,
            'clinic_address' => $this->clinic_address,
            'about_me' => $this->about_me,
            'professional_title' => $this->professional_title,
            'consultation_price' => $this->consultation_price,
            'offers_teleconsultation' => $this->offers_teleconsultation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Puedes incluir la relación de usuario si la necesitas
            // 'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}