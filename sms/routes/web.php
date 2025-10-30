<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Or if using custom routes
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

//SuperAdmin only routes (most powerful)
Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::get('/super-admin', function () {
        return "Super Admin Panel - Can manage everything";
    });
});

// SchoolAdmin routes (school management)
Route::middleware(['auth', 'role:SchoolAdmin'])->group(function () {
    Route::get('/school-admin', function () {
        return "School Admin Panel - Manages school operations";
    });
});

// Teacher routes (teaching functions)
Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('/teacher/grades', function () {
        return "Teacher - Grade Management";
    });
    Route::get('/teacher/attendance', function () {
        return "Teacher - Attendance Tracking";
    });
});

// Student routes (student access only)
Route::get('/student/portal', function () {
    return "Student Portal - View grades and schedule";
})->middleware(['auth', 'role:Student']);

// Bursar routes (financial only)
Route::get('/bursar/fees', function () {
    return "Bursar - Fee Management";
})->middleware(['auth', 'role:Bursar']);

// Default dashboard (any authenticated user)
Route::get('/dashboard', function () {
    return "General Dashboard";
})->middleware('auth');
