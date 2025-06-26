<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use App\Http\Resources\MedicalRecordResource;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with(['patient', 'doctor', 'appointment'])->get();
        return MedicalRecordResource::collection($medicalRecords);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'record_date' => 'required|date',
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $medicalRecord = MedicalRecord::create($request->all());
        return new MedicalRecordResource($medicalRecord);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment']); // Load relations for show method
        return new MedicalRecordResource($medicalRecord);
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'sometimes|required|exists:patients,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'record_date' => 'sometimes|required|date',
            'diagnosis' => 'sometimes|required|string|max:255',
            'treatment' => 'sometimes|required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $medicalRecord->update($request->all());
        return new MedicalRecordResource($medicalRecord);
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return response()->noContent();
    }
}