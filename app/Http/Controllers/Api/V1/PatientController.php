<?php

namespace App\Http\Controllers\Api\V1; // Tu nuevo namespace

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PatientResource;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all(); // O Patient::paginate(10);
        return PatientResource::collection($patients); // <-- Usa el recurso
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|unique:patients,email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient = Patient::create($request->all());
        return new PatientResource($patient); // <-- Usa el recurso
    }

    public function show(Patient $patient)
    {
        return new PatientResource($patient); // <-- Usa el recurso
    }

    public function update(Request $request, Patient $patient)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'date_of_birth' => 'sometimes|required|date',
            'gender' => 'sometimes|required|in:male,female,other',
            'phone_number' => 'sometimes|required|string|max:20',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('patients')->ignore($patient->id),
            ],
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient->update($request->all());
        return new PatientResource($patient); // <-- Usa el recurso
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->noContent();
    }
}