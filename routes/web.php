<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalPersonnelController;
use App\Http\Controllers\StaffController;

// General Routes
// Route::get('/welcome', function () {
//     return view('auth.welcome');
// })->name('welcome');
Route::get('/', function () {return redirect('login');});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Medical Personnel Routes
Route::get('/register/medical', [MedicalPersonnelController::class, 'showRegistrationForm'])->name('register.medical');
Route::post('/register/medical', [MedicalPersonnelController::class, 'register'])->name('register.medical.submit');

// Staff Routes
Route::get('/register/staff', [StaffController::class, 'showRegistrationForm'])->name('register.staff');
Route::post('/register/staff', [StaffController::class, 'register'])->name('register.staff.submit');
