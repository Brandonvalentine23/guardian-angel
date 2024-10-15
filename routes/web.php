<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalPersonnelController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MedicalPersonnelForgotPasswordController;
use App\Http\Controllers\StaffForgotPasswordController;

// General Routes
// General Routes
Route::get('/', function () {
    return redirect('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Medical Personnel and Staff routes
Route::get('/register/medical', [MedicalPersonnelController::class, 'showRegistrationForm'])->name('register.medical');
Route::post('/register/medical', [MedicalPersonnelController::class, 'register'])->name('register.medical.submit');

Route::get('/register/staff', [StaffController::class, 'showRegistrationForm'])->name('register.staff');
Route::post('/register/staff', [StaffController::class, 'register'])->name('register.staff.submit');

// POST login route
// GET route to display login form
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// POST route to handle login form submission of staff
Route::post('/login/admin', [StaffController::class, 'loginAdmin'])->name('login.admin');

// Route for the dashboard (welcome page)
Route::get('/welcome', function () {
    return view('auth.welcome');  // This is your dashboard view
})->middleware('auth')->name('welcome');

// GET route to display login form MP
Route::get('/loginMP', function () {
    return view('auth.loginMP');
})->name('loginMP');

// POST route to handle login form submission of MP
Route::post('/login/MP', [MedicalPersonnelController::class, 'loginMP'])->name('login.MP');

Route::get('/welcomeMP', function () {
    return view('auth.welcomeMP');
})->name('welcome.MP');

// Logout Route
Route::get('/logout', [StaffController::class, 'logout'])->name('logout');

// POST route to handle Staff registration form submission
Route::post('/register/staff', [StaffController::class, 'register'])->name('register.staff.submit');

// route for forget password
Route::get('/emailMP', function () {
    return view('auth.passwords.emailMP');  // This points to the email entry form view
})->name('password.request.MP');

// Password reset // Request password reset link for medical personnel
// Route::get('/passwords/resetMP', [MedicalPersonnelForgotPasswordController::class, 'showLinkRequestForm'])->name('CHANGE-LATER');

// Send password reset email for medical personnel
Route::post('/passwords/emailMP', [MedicalPersonnelForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.MP');

// Show reset form with token for medical personnel
Route::get('/passwords/resetMP/{token}', [MedicalPersonnelForgotPasswordController::class, 'showResetForm'])->name('password.reset');

// Process password reset for medical personnel
Route::post('/passwords/resetMP', [MedicalPersonnelForgotPasswordController::class, 'reset'])->name('password.update.MP');


// Forgot password form for staff
Route::get('/emailStaff', function () {
    return view('auth.passwords.emailStaff');
})->name('password.request.staff');

// Send reset link for staff
Route::post('/passwords/emailStaff', [StaffForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.staff');

// Show reset form with token for staff
Route::get('/passwords/ResetStaff/{token}', [StaffForgotPasswordController::class, 'showResetForm'])->name('password.reset.staff');

// Process password reset for staff
Route::post('/passwords/ResetStaff', [StaffForgotPasswordController::class, 'reset'])->name('password.update.staff');