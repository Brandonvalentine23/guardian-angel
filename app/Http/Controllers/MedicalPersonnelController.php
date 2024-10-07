<?php

namespace App\Http\Controllers;

use App\Models\MedicalPersonnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MedicalPersonnelController extends Controller
{
    public function showRegistrationForm()
    {
        // Ensure the view file exists at resources/views/auth/register-medical.blade.php
        return view('auth.register-medical');
    }

    public function register(Request $request)
    {
        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:medical_personnels',
            'password' => 'required|string|min:8|confirmed', // confirmed requires password_confirmation field
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:medical_personnels',
        ]);

        // Create new MedicalPersonnel record
        MedicalPersonnel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'specialization' => $request->specialization,
            'license_number' => $request->license_number,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        // Redirect to login page with a success message
        return redirect()->route('login')->with('status', 'Medical Personnel registered successfully');
    }
}