<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-staff'); // Ensure the view exists
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:staff',
            'password' => 'required|string|min:8|confirmed',
            'department' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('status', 'Staff registered successfully');
    }

    public function loginAdmin(Request $request) {
        $credentials = request()->only('email', 'password');

        // Find the staff from the DB using your credentials
        $staff = Staff::where('email', $credentials['email'])->first();

        // If the staff does not exist, return error message
        if (!$staff) {
            return back()->withErrors([
                'email' => 'No staff with this email exists.',
            ]);
        }

        if (!Hash::check($credentials['password'], $staff->password)) {
            return back()->withErrors([
                'password' => 'The password you entered was incorrect.',
            ]);
        }

        Auth::login($staff);
        $request->session()->regenerate();
        return redirect()->route('welcome');
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}