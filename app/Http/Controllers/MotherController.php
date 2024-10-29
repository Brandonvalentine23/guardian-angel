<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MotherController extends Controller
{
    // Show the mother registration form
    public function showRegistrationForm()
    {
        return view('motherinfant.pair');
    }

    // Handle the registration of a mother
    public function register(Request $request)
    {
        // Validate the form input
        $request->validate([
            'identity_card_number' => 'required|string|max:255|unique:mothers',
            'mother_name' => 'required|string|max:255',
            'sex' => 'required|string',
            'mother_dob' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|string|email|max:255',
            //'emergency_phone' => 'required|string|max:20',
            //'emergency_email' => 'nullable|string|email|max:255',
           // 'address' => 'required|string',
           // 'city' => 'required|string|max:100',
           // 'state' => 'required|string|max:100',
           //    'postal_code' => 'required|string|max:20',
            'marital_status' => 'nullable|string',
            'minor_status' => 'boolean',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string|max:255',
            'pregnancy_history' => 'nullable|string',
        ]);
    
        // Handle the checkbox value
        $minor_status = $request->has('minor_status') ? 1 : 0;
    
        // Create a new mother record
        Mother::create([
            'identity_card_number' => $request->identity_card_number,
            'mother_name' => $request->mother_name,
            'sex' => $request->sex,
            'mother_dob' => $request->mother_dob,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            //'emergency_phone' => $request->emergency_phone,
            //'emergency_email' => $request->emergency_email,
            //'address' => $request->address,
            //'city' => $request->city,
            //'state' => $request->state,
           // 'postal_code' => $request->postal_code,
            'marital_status' => $request->marital_status,
            'minor_status' => $minor_status,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'pregnancy_history' => $request->pregnancy_history,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    
        // Redirect back with a success message
        return back()->with('status', 'Mother registered successfully.');
    }
}