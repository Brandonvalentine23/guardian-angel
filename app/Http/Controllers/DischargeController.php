<?php

namespace App\Http\Controllers;

use App\Models\Newborn;
use App\Models\MedicationAdministration;
use Illuminate\Http\Request;

class DischargeController extends Controller
{
    public function handleDischarge(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'rfid_uid' => 'required|string',
            'discharge_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Perform necessary actions here (e.g., save discharge record if needed)

        // Redirect to the details page with the RFID UID
        return redirect()->route('discharge', ['rfid_uid' => $validated['rfid_uid']]);
    }

    public function showPatientDetails($rfid_uid)
    {
        // Find the newborn by RFID UID
        $newborn = Newborn::with(['mother', 'medicationAdministrations'])->where('rfid_uid', $rfid_uid)->firstOrFail();

        // Pass the details to the view
        return view('auth.discharge', compact('newborn'));
    }
}