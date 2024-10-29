<?php

namespace App\Http\Controllers;

use App\Models\Newborn;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewbornController extends Controller
{
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
            'mother_name' => 'required|string|max:255',
            'mother_religion' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_religion' => 'nullable|string|max:255',
        ]);

        // Create a new newborn record
        Newborn::create([
            'newborn_name' => $request->newborn_name,
            'newborn_dob' => $request->newborn_dob,
            'gender' => $request->gender,
            'birth_weight' => $request->birth_weight,
            'blood_type' => $request->blood_type,
            'health_conditions' => $request->health_conditions,
            'mother_name' => $request->mother_name,
            'mother_religion' => $request->mother_religion,
            'father_name' => $request->father_name,
            'father_religion' => $request->father_religion,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Redirect back with a success message
        return back()->with('status', 'Newborn registered successfully.');
    }
}