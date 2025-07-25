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

    // Save the application to database (assuming you have an Application model)
    $application = new \App\Models\Application();
    $application->job_id = $jobId;
    $application->name = $request->name;
    $application->email = $request->email;
    $application->cover_letter = $request->cover_letter;

    // Store uploaded resume
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
}
