<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionGroupController;
use App\Http\Middleware\IsAdmin;
// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/admin/jobs', [JobController::class, 'adminIndex'])->name('admin.jobs.index')->middleware('role:admin');

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/job-applications', [AdminController::class, 'jobApplications'])->name('admin.job-applications.index');
Route::get('/admin/jobs/{id}/view', [JobController::class, 'adminShow'])->name('admin.jobs.show');
// Change this:
Route::patch('/admin/jobs/{job}', [JobController::class, 'update'])->name('admin.jobs.update');

// To this if using PUT in Blade:
Route::put('/admin/jobs/{job}', [JobController::class, 'update'])->name('admin.jobs.update');


    // Job posting (admin only)
    Route::get('/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
});


Route::get('/admin/applications/{id}', [App\Http\Controllers\JobApplicationController::class, 'show'])
    ->name('admin.applications.show')
    ->middleware(['auth', 'role:admin']);

// User-only routes
Route::middleware(['auth', 'role:user,admin'])->group(function () {

    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Browse jobs and apply
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}/apply', [JobApplicationController::class, 'showApplyForm'])->name('jobs.apply.form');
    Route::post('/jobs/{id}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');

    // View user's applications
    Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->name('applications.my');
});
// Admin-only routes







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


//edit posted job
Route::get('/admin/jobs/{job}/edit', [JobController::class, 'edit'])->name('admin.jobs.edit');


Route::get('/admin/applications', [JobApplicationController::class, 'index'])->name('admin.applications.index');



Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('questions', [QuestionGroupController::class, 'index'])->name('admin.questions.index');
    Route::get('questions/create', [QuestionGroupController::class, 'create'])->name('admin.questions.create');
    Route::post('questions', [QuestionGroupController::class, 'store'])->name('admin.questions.store');
    Route::get('questions/{id}', [QuestionGroupController::class, 'show'])->name('admin.questions.show');
    Route::delete('questions/{id}', [QuestionGroupController::class, 'destroy'])->name('admin.questions.destroy');
});


Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('questions', QuestionGroupController::class)->names([
        'index' => 'admin.questions.index',
        'create' => 'admin.questions.create',
        'store' => 'admin.questions.store',
        'show' => 'admin.questions.show',
        'destroy' => 'admin.questions.destroy',
    ]);
});
// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';
