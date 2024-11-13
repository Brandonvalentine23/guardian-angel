<?php

// MedicationAdministrationController.php

namespace App\Http\Controllers;

use App\Models\Newborn;
use App\Models\MedicationAdministration;
use Illuminate\Http\Request;

class MedicationAdministrationController extends Controller
{
    // Method to show the list of newborns
    public function index()
    {
        $newborns = Newborn::with('medicationAdministrations')->get(); // Fetch all newborns with their medications
        return view('auth.med.medicine-view', compact('newborns'));
    }

    // Method to store medication administration details
    public function store(Request $request)
    {
        $request->validate([
            'newborn_id' => 'required|exists:newborns,id',
            'medication_type' => 'required|string|max:255',
            'administration_time' => 'required|string',
            'dose' => 'required|string|max:255',
        ]);

        MedicationAdministration::create([
            'newborn_id' => $request->newborn_id,
            'medication_type' => $request->medication_type,
            'administration_time' => $request->administration_time,
            'dose' => $request->dose,
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
    $medication = MedicationAdministration::findOrFail($id);
    $medication->done = true; // Assuming you add a 'done' column in your table
    $medication->save();

    return redirect()->back()->with('success', 'Medication marked as done.');
}

// Method to delete a medication
public function delete($id)
{
    $medication = MedicationAdministration::findOrFail($id);
    $medication->delete();

    return redirect()->back()->with('success', 'Medication deleted successfully.');
}

}