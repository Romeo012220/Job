<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\JobAnswer;
use App\Models\JobQuestion;

class JobApplicationController extends Controller
{
    public function showApplyForm($id)
    {
        $job = Job::with('questionGroup.questions')->findOrFail($id);
        return view('jobs.apply', compact('job'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx',
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string',
        ]);

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        // Save application
        $application = JobApplication::create([
            'job_id' => $validated['job_id'],
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cover_letter' => $validated['cover_letter'] ?? null,
            'resume_path' => $validated['resume_path'] ?? null,
        ]);

        // Save answers (if any)
        if ($request->filled('answers')) {
            foreach ($request->input('answers') as $questionId => $answerText) {
                if (!empty($answerText)) {
                    JobAnswer::create([
                        'job_application_id' => $application->id,
                        'job_question_id' => $questionId, // ✅ FIXED KEY
                        'answer' => $answerText,
                    ]);
                }
            }
        }

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
        $application = JobApplication::with(['answers.question'])->findOrFail($id);

        return view('admin.job-applications.showapplicantinfo', compact('application'));
    }

    public function index()
    {
        $applications = JobApplication::with('job')->latest()->paginate(10);

        return view('admin.job-applications.index', compact('applications'));
    }

    public function showUserApplicationInfo($id)
{
    $application = JobApplication::with(['job', 'answers.question'])
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('applications.showuserapplicationinfo', compact('application'));
}

public function showUserApplication(JobApplication $application)
{
    // Ensure the logged-in user owns this application
    if (auth()->id() !== $application->user_id) {
        abort(403);
    }

    return view('applications.showuserapplicationinfo', [
        'application' => $application
    ]);
}



}
