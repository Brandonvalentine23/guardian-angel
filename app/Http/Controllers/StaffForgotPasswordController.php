<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\Staff;

class StaffForgotPasswordController extends Controller
{
    // Use the trait to handle sending password reset emails
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        // Step 1: Validate the email input
        $request->validate(['email' => 'required|email']);

        // Step 2: Check if the staff account exists
        $staff = Staff::where('email', $request->email)->first();

        if (!$staff) {
            // If no staff found, return an error message
            return back()->withErrors([
                'email' => 'No staff with this email address exists.',
            ]);
        }

        // Step 2.2: Send the reset link
        $response = $this->broker()->sendResetLink(['email' => $request->email]);

        // Step 3: Handle the response
        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }

        return back()->withErrors(['email' => trans($response)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        // Step 1: Validate the request input
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Step 2: Attempt to reset the staff's password
        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($staff, $password) {
                $staff->password = bcrypt($password);
                $staff->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', trans($response));
        }

        return back()->withErrors(['email' => trans($response)]);
    }

    // Override the broker method to use the 'staff' broker
    protected function broker()
    {
        return Password::broker('staff');
    }
}