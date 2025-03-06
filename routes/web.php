<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('registration.login');
});

// Guest routes (for registration and login)
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('registration.register');
    })->name('register');
    
    Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.adminDashboard');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});


// Student routes
Route::resource('students', StudentController::class);
Route::delete('enrollments/{student}/{subject}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
    
// Subject routes
Route::resource('subjects', SubjectController::class);

// Enrollment routes
Route::get('/enroll/{student}', [EnrollmentController::class, 'create'])->name('enroll.create');
Route::post('/enroll/{student}', [EnrollmentController::class, 'store'])->name('enroll.store');
Route::delete('/enroll/{student}/{subject}', [EnrollmentController::class, 'destroy'])->name('enroll.remove');

// Grade routes
Route::get('/grades/{student}', [GradeController::class, 'edit'])->name('grades.edit');
Route::put('/grades/{student}', [GradeController::class, 'update'])->name('grades.update');

require __DIR__.'/auth.php';
