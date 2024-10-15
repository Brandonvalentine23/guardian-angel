<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\MedicalPersonnel;

class MedicalPersonnelForgotPasswordController extends Controller
{
    // Use the trait to handle sending password reset emails
    use SendsPasswordResetEmails;

    //
    public function sendResetLinkEmail(Request $request)
    {
       // Step 1: Validate the email input
        $request->validate(['email' => 'required|email']);

        // Step 2: Check if the Medical Personnel account exists
        $medicalPersonnel = MedicalPersonnel::where('email', $request->email)->first();

        if (!$medicalPersonnel) {
                // If no Medical Personnel found, return an error message
                return back()->withErrors([
                    'email' => 'No Medical Personnel with this email address exists.',
                ]);
            }
        

        // Step 2.2: send the reset link
        $response = $this->broker()->sendResetLink(
            // $request->only('email')
            ['email' => $request->email]
        );

        // Step 3: Handle the response
        if ($response == Password::RESET_LINK_SENT) {
            // If reset link was sent, redirect back with a success message
            return back()->with('status', trans($response)); // Uses Laravel's translation system
        }

        // Step 4: If something goes wrong, return with an error
        return back()->withErrors(['email' => trans($response)]);
    }
    
    public function showResetForm(Request $request, $token = null)
    {
        // Render the reset password view, passing the token and the email to the view
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request) {
        // Step 1: Validate the request input (token, email, password, password confirmation)
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Step 2: Attempt to reset the user's password
        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($medicalPersonnel, $password) {
                // Step 3: Update the password for the Medical Personnel
                $medicalPersonnel->password = bcrypt($password);
                $medicalPersonnel->save();
            }
        );

        // Step 4: Handle success or failure
        if ($response == Password::PASSWORD_RESET) {
            // If the reset was successful, redirect with a success message
            return redirect()->route('loginMP')->with('status', trans($response));
        }

        // If reset failed, return back with errors
        return back()->withErrors(['email' => trans($response)]);
    }

    // Show the form for requesting password reset link
    // public function showLinkRequestForm()
    // {
    //     return view('auth.passwords.emailMP'); // This matches your emailMP.blade.php
    // }

    // Override the broker method to use the 'medical_personnel' broker
    protected function broker()
    {
        return Password::broker('medical_personnel'); // This should be set in your auth.php
    }
}