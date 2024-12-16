<?php

namespace App\Http\Controllers;

use App\Models\Newborn;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Mother;

class NewbornController extends Controller
{
    // Method to store a newborn record
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'newborn_name' => 'required|string|max:255',
            'newborn_dob' => 'required|date',
            'gender' => 'required|string',
            'birth_weight' => 'required|numeric|min:0',
            'blood_type' => 'nullable|string',
            'health_conditions' => 'nullable|string|max:255',
            'mother_id' => 'required|exists:mothers,id',
            'rfid_uid' => 'required|string',
            'birth_notes' => 'nullable|string',
        ]);

        // Retrieve mother_name using the mother_id from the request
        $mother = Mother::findOrFail($request->mother_id); // Find the mother by ID

        // Calculate the gestational age in weeks
        $dob = Carbon::parse($request->newborn_dob);
        $currentDate = Carbon::now();
        $gestationalAge = $dob->diffInWeeks($currentDate);

        // Create a new newborn record
        Newborn::create([
            'newborn_name' => $request->newborn_name,
            'newborn_dob' => $request->newborn_dob,
            'gender' => $request->gender,
            'birth_weight' => $request->birth_weight,
            'blood_type' => $request->blood_type,
            'health_conditions' => $request->health_conditions,
            'mother_id' => $request->mother_id,
            'mother_name' => $mother->mother_name,
            'rfid_uid' => $request->rfid_uid,
            'birth_notes' => $request->birth_notes,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Redirect back with a success message
        return back()->with('status', 'Newborn registered and paired with mother successfully.');
    }

    // Method to show the newborn registration form and list of mothers
    public function pairtomother()
    {
        $mothers = Mother::all(); // Fetch all mothers
        return view('auth.pairing.newbornreg', [
            'mothers' => $mothers,
        ]);
    }

    // Method to show newborn files with associated mothers
    public function showFiles()
    {
        $newborns = Newborn::with('mother')->get(); // Fetch newborn records with associated mothers
        return view('auth.newbornfile', compact('newborns')); // Pass data to the view
    }

    // Method to pair RFID UID with a newborn
    public function pairRfid(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'rfid_uid' => 'required|string',
            'newborn_id' => 'required|exists:newborns,id', // Ensure the newborn ID exists in the database
        ]);

        // Find the newborn and update the RFID UID
        $newborn = Newborn::findOrFail($request->newborn_id);
        $newborn->rfid_uid = $request->rfid_uid;
        $newborn->save();

        return response()->json([
            'message' => 'RFID UID paired successfully.',
            'newborn' => $newborn,
        ], 200);
    }

    // Method to save UID for the latest unpaired newborn
    public function saveUid(Request $request)
    {
        // Validate the incoming request to ensure 'uid' is provided
        $validated = $request->validate([
            'uid' => 'required|string',
        ]);

        // Retrieve the UID from the request
        $uid = $validated['uid'];

        // Find the most recent newborn record that needs pairing
        $newborn = Newborn::whereNull('rfid_uid')->latest()->first();

        if ($newborn) {
            // Assign the UID to the newborn record
            $newborn->rfid_uid = $uid;
            $newborn->save(); // Save the updated record in the database

            return response()->json(['message' => 'UID saved successfully!']);
        } else {
            return response()->json(['message' => 'No newborn record found to associate with this UID.'], 404);
        }
    }
    public function search(Request $request)
    {
        // Capture the search query
        $search = $request->input('search');
    
        // Fetch records based on the search query or show all if the search is empty
        $newborns = Newborn::when($search, function ($query, $search) {
            return $query->where('newborn_name', 'LIKE', '%' . $search . '%');
        })
        ->with('mother') // Include associated mother information
        ->get();
    
        // Return the view with the search results
        return view('auth.newbornfile', compact('newborns', 'search'));
    }
    
    public function searchByRfid(Request $request)
{
    // Validate that 'uid' is present in the request
    $request->validate([
        'uid' => 'required|string',
    ]);

    // Query the newborn table for the provided RFID UID
    $newborn = Newborn::where('rfid_uid', $request->uid)->with('mother')->first();

    if ($newborn) {
        return response()->json(['newborn' => $newborn], 200);
    } else {
        return response()->json(['message' => 'No newborn record found for this RFID UID.'], 404);
    }
}

// In a Controller (e.g., NewbornController)
public function getNewbornRegistrations()
{
    // Aggregate data by date of registration
    $registrations = Newborn::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // Return the aggregated data as JSON
    return response()->json($registrations);
}

}