<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalPersonnelController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MedicalPersonnelForgotPasswordController;
use App\Http\Controllers\StaffForgotPasswordController;
use App\Http\Controllers\MotherController;
use App\Http\Controllers\NewbornController;
use App\Http\Controllers\PairingController;
use App\Http\Controllers\MedicationAdministrationController;
use App\Http\Controllers\HardwareManagementController;
use App\Http\Controllers\LocationLogController;
use App\Http\Controllers\AlertAndNotificationController;
use App\Http\Controllers\MedicalNotificationController;
use App\Http\Controllers\DischargeController;
use App\Http\Controllers\DashboardController;
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

//mother infant pair viewe route
Route::get('/motherinfantpair', function () {
    return view('auth.pairing.motherinfantpair');
})->name('motherinfant.pair');

//newborn view route
Route::get('/newbornreg', function () {
    return view('auth.pairing.newbornreg');
})->name('newborn.reg');

Route::get('/newbornreg', [NewbornController::class, 'pairtomother'])->name('newborn.reg');


Route::post('/mother/register', [MotherController::class, 'register'])->name('mother.submit');


Route::post('/newborn/register', [NewbornController::class, 'store'])->name('newborn.store');

Route::get('/manage', function () {
    return view('auth.pairing.manage');
})->name('manage.pair');

Route::get('/manage', [PairingController::class, 'seelist'])->name('manage.pair');

// Pairing Routes
Route::get('/pairs', [PairingController::class, 'index'])->name('pairs.index');  // View all pairs
Route::get('/pairs/{id}/edit', [PairingController::class, 'edit'])->name('pairs.edit');  // Edit a pair
Route::post('/pairs/{id}/update', [PairingController::class, 'update'])->name('pairs.update');  // Update pair
Route::delete('/pairs/{id}', [PairingController::class, 'destroy'])->name('pairs.destroy');  // Delete pair

// Route for displaying newborn files
Route::get('/newbornfile', [NewbornController::class, 'showFiles'])->name('newborn.file');
Route::get('/api/newborn/registrations', [NewbornController::class, 'getNewbornRegistrations']);



Route::get('/medication-administration', [MedicationAdministrationController::class, 'index'])->name('medication-administration.index');
Route::get('/medication-administration/create', [MedicationAdministrationController::class, 'create'])->name('medication-administration.create');
Route::post('/medication-administration/store', [MedicationAdministrationController::class, 'store'])->name('medication-administration.store');
Route::post('/medication-administration/{id}/mark-as-done', [MedicationAdministrationController::class, 'markAsDone'])->name('medication-administration.markAsDone');
Route::delete('/medication-administration/delete/{id}', [MedicationAdministrationController::class, 'delete'])->name('medication-administration.delete');

// routes/api.php
Route::post('/newborn/pair-rfid', [NewbornController::class, 'pairRfid']);
Route::post('/save-uid', [NewbornController::class, 'saveUid']);


Route::get('/report', function () {
    return view('auth.report');
})->name('report');



// Route using the MedicationAdministrationController
Route::get('/medication-overview', [MedicationAdministrationController::class, 'overview'])->name('medication-administration.overview');

Route::get('/newborn/search', [NewbornController::class, 'search'])->name('newborn.search');
Route::get('/rfid-search', [NewbornController::class, 'searchByRfid'])->name('rfid.search');

//Hardware management route
Route::get('/hardware-manage', [HardwareManagementController::class, 'index'])->name('hardware.manage');
Route::post('/hardware-status', [HardwareManagementController::class, 'updateHardwareStatus']);

// TROUBLESHOOT IN PROGRESS
Route::get('/location/logs', [LocationLogController::class, 'showLocationLogs'])->name('location.log');

// TROBLESHOOT IN PROGRESS
Route::get('/getlocations', [LocationLogController::class, 'getLocationLogs'])->name('location.log.get');

Route::get('/next-medication', [MedicationAdministrationController::class, 'getNextMedication']);
Route::get('/medication-alerts', [MedicationAdministrationController::class, 'getMedicationAlerts']);


Route::get('/alert-notification', [AlertAndNotificationController::class, 'index'])->name('alert.admin');
Route::get('/welcomeMP', [AlertAndNotificationController::class, 'welcomeMP'])->name('welcome.MP');
Route::get('/mednotiandalert', [MedicalNotificationController::class, 'index'])->name('medicalpersonnel.notifications');
// Route::get('/mednotiandalert', [MedicalNotificationController::class, 'index'])->name('medicalpersonnel.notifications');

// Handle form submission
Route::post('/discharge/handle', [DischargeController::class, 'handleDischarge'])->name('discharge.handle');

// Display patient details
Route::get('/discharge/show/{rfid_uid}', [DischargeController::class, 'showPatientDetails'])->name('discharge');




// Dashboard route
Route::get('/welcomeMP', [DashboardController::class, 'index'])->name('welcome.MP'); // Load the dashboard
Route::post('/fetch-info', [DashboardController::class, 'fetchInfo'])->name('dashboard.fetchInfo');

Route::post('/rfid-info', [DashboardController::class, 'fetchInfo'])->name('rfid.info'); // Fetch RFID details
Route::get('/welcomeMP', [DashboardController::class, 'index'])->name('welcome.MP');