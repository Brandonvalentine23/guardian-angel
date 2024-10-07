<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalPersonnel;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form based on the role (medical or staff).
     */
    public function showRegistrationForm($role = null)
    {
        if ($role == 'medical') {
            return view('auth.register-medical');
        } elseif ($role == 'staff') {
            return view('auth.register-staff');
        }

        // Default registration form if no role is specified
        return view('auth.register');
    }

    /**
     * Handle the registration for medical personnel.
     */
    public function registerMedicalPersonnel(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:medical_personnels',
            'password' => 'required|string|min:8|confirmed',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|unique:medical_personnels'
        ]);

        // Create the medical personnel
        MedicalPersonnel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialization' => $request->specialization,
            'license_number' => $request->license_number
        ]);

        // Redirect to the login page with success status
        return redirect()->route('login')->with('status', 'Medical Personnel registered successfully. Please log in.');
    }

    /**
     * Handle the registration for staff.
     */
    public function registerStaff(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:staff',
            'password' => 'required|string|min:8|confirmed',
            'department' => 'required|string|max:255',
            'role' => 'required|string|in:admin,support'
        ]);

        // Create the staff member
        Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'role' => $request->role
        ]);

        // Redirect to the login page with success status
        return redirect()->route('login')->with('status', 'Staff registered successfully. Please log in.');
    }
}