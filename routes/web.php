<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Job posting (admin only)
    Route::get('/admin/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
    Route::post('/admin/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
});

// User-only routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Browse jobs and apply
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}/apply', [JobApplicationController::class, 'showApplyForm'])->name('jobs.apply.form');
    Route::post('/jobs/{id}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');

    // View user's applications
    Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->name('applications.my');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::post('/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
});


// Profile management (for all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Optional default dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';
