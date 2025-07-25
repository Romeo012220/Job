<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function showApplyForm($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.apply', compact('job'));
    }
public function store(Request $request, $jobId)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'cover_letter' => 'nullable|string',
        'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $application = new JobApplication();
    $application->job_id = $jobId;
    $application->user_id = auth()->id();  // <== ADD THIS LINE
    $application->name = $request->name;
    $application->email = $request->email;
    $application->cover_letter = $request->cover_letter;

    if ($request->hasFile('resume')) {
        $application->resume_path = $request->file('resume')->store('resumes', 'public');
    }

    $application->save();

    return redirect()->route('jobs.index')->with('success', 'Application submitted successfully!');
}




    public function myApplications()
    {
        $applications = JobApplication::with('job')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.dashboard', compact('applications'));
    }
public function show($id)
{
    $application = JobApplication::with('job')->findOrFail($id);
    return view('admin.job-applications.showapplicantinfo', compact('application'));
}




public function index()
{
    $applications = JobApplication::with('job')->latest()->paginate(10);

    return view('admin.job-applications.index', compact('applications'));
}

}
