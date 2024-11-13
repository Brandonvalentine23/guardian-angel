<?php

namespace App\Http\Controllers;

use App\Models\Newborn;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Mother;

class NewbornController extends Controller
{
    public function store(Request $request)
    {
        // do it here first
        // $mother = Mother::where('id', $request->mother_id)->first();
        // $motherName = $mother->mother_name;
        // something else here i forgot

        // Validate the form input
       // Validate the form input
 // Validate form input
 $request->validate([
    'newborn_name' => 'required|string|max:255',
    'newborn_dob' => 'required|date',
    'gender' => 'required|string',
    'birth_weight' => 'required|numeric|min:0',
    'blood_type' => 'nullable|string',
    'health_conditions' => 'nullable|string|max:255',
    'mother_id' => 'required|exists:mothers,id',  // Ensure mother_id exists in mothers table
    'father_name' => 'nullable|string|max:255',
    'father_religion' => 'nullable|string|max:255',
]);

// Retrieve mother_name using the mother_id from the request
$mother = Mother::findOrFail($request->mother_id); // Find the mother by ID

// Create a new newborn record
Newborn::create([
    'newborn_name' => $request->newborn_name,
    'newborn_dob' => $request->newborn_dob,
    'gender' => $request->gender,
    'birth_weight' => $request->birth_weight,
    'blood_type' => $request->blood_type,
    'health_conditions' => $request->health_conditions,
    'mother_id' => $request->mother_id,
    'mother_name' => $mother->mother_name,  // Store mother_name from the selected mother
    'mother_religion' => $request->mother_religion,
    'father_name' => $request->father_name,
    'father_religion' => $request->father_religion,
    'created_at' => Carbon::now(),
    'updated_at' => Carbon::now(),
]);

    // Redirect back with a success message
    return back()->with('status', 'Newborn registered and paired with mother successfully.');
}

    public function pairtomother() {
        $mothers = Mother::all();

        return view('auth.pairing.newbornreg', [
            'mothers' => $mothers,
        ]);
    }

    public function showFiles()
{
    $newborns = Newborn::with('mother')->get(); // Fetch newborn records with associated mothers
    return view('auth.newbornfile', compact('newborns')); // Pass data to the view
}
}