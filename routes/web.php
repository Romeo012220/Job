<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionGroupController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\QuestionController;
// Redirect root to login

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//Route::resource('questions', QuestionController::class);
 //   Route::resource('questions', QuestionController::class);
    //Route::resource('questions', App\Http\Controllers\QuestionController::class);

    // Route::get('questions/{group}/add', [QuestionController::class, 'addQuestion'])->name('questions.add');
  //  Route::post('questions/{group}/add', [QuestionController::class, 'storeQuestion'])->name('questions.storeQuestion');

    // Group question updates/deletes (custom, if not handled in QuestionController)
    Route::put('questions/{id}/update-question', [QuestionGroupController::class, 'updateQuestion'])->name('questions.updatequestion');
  //  Route::delete('questions/{id}/delete', [QuestionGroupController::class, 'deleteQuestion'])->name('questions.delete');



  // Route to view all question groups
   // Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

    // Route to show individual question group and its questions
   // Route::get('/questions/group/{id}', [QuestionController::class, 'viewGroup'])->name('question-groups.show');

    // Create question form
   // Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');

    // Store question (you may still need to implement logic here)
    //Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    // Edit question form
   // Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');

    // Update question
   // Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');

    // Delete question
  //  Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    // Store new group
    Route::post('/question-groups', [QuestionController::class, 'storeGroup'])->name('question-groups.store');

});

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



Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
   // Route::resource('questions', \App\Http\Controllers\QuestionGroupController::class);
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


//edit posted job
Route::get('/admin/jobs/{job}/edit', [JobController::class, 'edit'])->name('admin.jobs.edit');


Route::get('/admin/applications', [JobApplicationController::class, 'index'])->name('admin.applications.index');



Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
   Route::get('questions', [QuestionGroupController::class, 'index'])->name('admin.questions.index');
 Route::get('questions/create', [QuestionGroupController::class, 'create'])->name('admin.questions.create');
    Route::post('questions', [QuestionGroupController::class, 'store'])->name('admin.questions.store');
 //   Route::get('questions/{id}', [QuestionGroupController::class, 'show'])->name('admin.questions.show');
    Route::delete('questions/{id}', [QuestionGroupController::class, 'destroy'])->name('admin.questions.destroy');
});


//Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
  //  Route::resource('questions', QuestionGroupController::class)->names([
    //    'index' => 'admin.questions.index',
      //  'create' => 'admin.questions.create',
        //'store' => 'admin.questions.store',
        //'show' => 'admin.questions.show',
        //'destroy' => 'admin.questions.destroy',
    //]);
//});

Route::get('question-groups/{id}', [\App\Http\Controllers\Admin\QuestionGroupController::class, 'show'])->name('admin.question-groups.show');


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
  //  Route::resource('questions', QuestionController::class);
   //Route::resource('questions', QuestionController::class);
    Route::get('question-groups/{group}', [QuestionController::class, 'viewGroup'])->name('question-groups.show');
    
});
//Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
  //Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
    //Route::resource('question-groups', \App\Http\Controllers\Admin\QuestionGroupController::class);
//});

//Route::get('/admin/questions', [\App\Http\Controllers\Admin\QuestionGroupController::class, 'index'])->name('admin.questions.index');

Route::get('/admin/questions/{question}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');


//Route::put('/admin/questions/{question}', [QuestionController::class, 'update'])->name('admin.questions.update');


Route::get('/admin/questions/{group}/add', [QuestionController::class, 'addQuestion'])->name('admin.questions.add');
Route::post('/admin/questions/{group}/add', [QuestionController::class, 'storeQuestion'])->name('admin.questions.storeQuestion');


// For updating an individual question
//Route::put('/admin/questions/{id}/update-question', [QuestionGroupController::class, 'updateQuestion'])->name('admin.questions.updatequestion');

// For deleting an individual question
Route::delete('/admin/questions/{id}/delete', [QuestionGroupController::class, 'deleteQuestion'])->name('admin.questions.delete');


Route::post('/admin/jobs/{job}/close', [JobController::class, 'closeJob'])->name('admin.jobs.close');


Route::get('/jobs/{id}/view', [JobController::class, 'viewJobPost'])->name('jobs.view');


Route::middleware(['auth'])->group(function () {
    Route::get('/my-applications/{application}', [JobApplicationController::class, 'showUserApplication'])
        ->name('applications.show');
});

Route::get('admin/jobs/{job}/show', [JobController::class, 'show'])->name('admin.jobs.show');

//admin message
Route::post('/admin/applications/message', [\App\Http\Controllers\JobApplicationController::class, 'sendMessage'])
    ->name('admin.applications.sendMessage');

//User reply message
    Route::post('/messages/reply', [JobApplicationController::class, 'replyMessage'])->name('messages.reply');

//admin message with user repply
    Route::get('/admin/applications/{application}/messages', [JobApplicationController::class, 'getMessages']);

    //reopen closed job
Route::post('/admin/jobs/{job}/reopen', [JobController::class, 'reopen'])->name('admin.jobs.reopen');



//delete created jobs
Route::delete('/admin/jobs/{job}', [JobController::class, 'destroy'])->name('admin.jobs.destroy');


// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';
