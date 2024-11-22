<?php

namespace App\Http\Controllers;

use App\Models\MedicalPersonnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedicalPersonnelController extends Controller
{
    // Show the registration form for Medical Personnel
    public function showRegistrationForm()
    {
        return view('auth.register-medical');
    }

    // Handle the registration of Medical Personnel
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Stay on the same registration page with a success message
        return back()->with('status', 'Medical Personnel registered successfully.');
    }

    // Handle the login for Medical Personnel
    public function loginMP(Request $request) {
        $credentials = request()->only('email', 'password');

        // Find the medical personnel from the DB using your credentials
        $medicalPersonnel = MedicalPersonnel::where('email', $credentials['email'])->first();

        // If the staff does not exist, return error message
        if (!$medicalPersonnel) {
            return back()->withErrors([
                'email' => 'No Medical Personal with this email exists.',
            ]);
        }

        if (!Hash::check($credentials['password'], $medicalPersonnel->password)) {
            return back()->withErrors([
                'password' => 'The password you entered was incorrect.',
            ]);
        }

        Auth::guard('web_mp')->login($medicalPersonnel);
        $request->session()->regenerate();
        return redirect()->route('welcome.MP');
    }

    // Handle the logout for Medical Personnel
    public function logoutMP(Request $request)
    {
        Auth::guard('web_mp')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}