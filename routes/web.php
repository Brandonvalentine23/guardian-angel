<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalPersonnelController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;

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
