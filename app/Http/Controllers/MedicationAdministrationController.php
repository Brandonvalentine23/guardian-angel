<?php

// MedicationAdministrationController.php

namespace App\Http\Controllers;

use App\Models\Newborn;
use App\Models\MedicationAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicationAdministrationController extends Controller
{
    // Method to show the list of newborns
    public function index()
    {
        $newborns = Newborn::with('medicationAdministrations')->get();

    // Fetch all newborns with their medications
        return view('auth.med.medicine-view', [
            'newborns' => $newborns,
        ]);
    }

    // Method to store medication administration details
    public function store(Request $request)
    {
        $request->validate([
            'newborn_id' => 'required|exists:newborns,id',
            'medication_name' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'administration_time' => 'required|date',
            'dose' => 'required|string|max:255',
            'diagnosis' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'administered_by' => 'required|string|max:255',
            'birth_weight' => 'nullable|string|max:255',
            'gestational_age' => 'nullable|string|max:255',
        ]);

        MedicationAdministration::create([
            'newborn_id' => $request->newborn_id,
            'medication_name' => $request->medication_name,
            'frequency' => $request->frequency,
            'route' => $request->route,
            'administration_time' => $request->administration_time,
            'dose' => $request->dose,
            'diagnosis' => $request->diagnosis,
            'instructions' => $request->instructions,
            'administered_by' => $request->administered_by,
            'birth_weight' => $request->birth_weight,
            'gestational_age' => $request->gestational_age,
        ]);

        return redirect()->route('medication-administration.index')->with('success', 'Medication administration recorded successfully.');
    }

    public function create(Request $request)
{
    // Retrieve the newborn ID from the request
    $newbornId = $request->query('id');

    if (!$newbornId) {
        return redirect()->back()->withErrors('Newborn ID is required.');
    }

    $newborn = Newborn::findOrFail($newbornId); // Retrieve the newborn by ID
    return view('auth.med.medication-administration', compact('newborn'));
}

// Method to mark a medication as done
public function markAsDone($id)
{
    // Update the status 'done' to true (1)
    DB::table('medication_administrations')
        ->where('newborn_id', $id)
        ->update([
            'done' => 1,
        ]);

    return redirect()->back()->with('success', 'Medication marked as done.');
}

// Method to delete a medication
public function delete(Request $request, $id)
{
    $medication_name = $request->medication_name;

    DB::table('medication_administrations')
        ->where('newborn_id', $id)
        ->where('medication_name', $medication_name)
        ->delete();

    return redirect()->back()->with('success', 'Medication deleted successfully.');
}
public function overview()
{
    $newborns = Newborn::with('medicationAdministrations')->get(); // Load medication data
    return view('auth.med.medication-overview', compact('newborns'));
}

}