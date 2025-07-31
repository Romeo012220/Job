<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\JobAnswer;
use App\Models\Message;
use App\Models\JobQuestion;

class JobApplicationController extends Controller
{
  public function showApplyForm($id)
{
    $job = Job::with('questionGroup.questions')->findOrFail($id);

    $alreadyApplied = JobApplication::where('job_id', $id)
        ->where('user_id', auth()->id())
        ->exists();

    return view('jobs.apply', compact('job', 'alreadyApplied'));
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
  $applications = JobApplication::with(['job', 'messages'])
    ->where('user_id', auth()->id())
    ->latest()
    ->paginate(10); // ✅ CORRECT

        

    return view('user.dashboard', compact('applications'));
}

public function show($id)
{
    $application = JobApplication::with([
        'answers.question',
        'messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }
    ])->findOrFail($id);

    return view('admin.job-applications.showapplicantinfo', compact('application'));
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

//message method
public function sendMessage(Request $request)
{
    $request->validate([
        'application_id' => 'required|exists:applications,id',
        'message' => 'required|string|max:1000',
    ]);

    $application = JobApplication::findOrFail($request->application_id);

    // Send email
    \Mail::raw($request->message, function ($mail) use ($application) {
        $mail->to($application->email)
             ->subject('Job Application Status');
    });

    // Save to DB
Message::create([
    'application_id' => $application->id,
    'message' => $request->message,
    'sender_type' => 'admin',
]);


    return redirect()->back()->with('success', 'Message sent successfully.');
}


//user reply message
public function replyMessage(Request $request)
{
    $request->validate([
        'application_id' => 'required|exists:applications,id',
        'message' => 'required|string|max:1000',
    ]);

    $application = JobApplication::findOrFail($request->application_id);

    // Optional: Check user owns the application
    if ($application->user_id !== auth()->id()) {
        abort(403);
    }

    Message::create([
        'application_id' => $application->id,
        'message' => $request->message,
        'sender_type' => 'user',
    ]);

    return redirect()->back()->with('success', 'Reply sent successfully.');
}

public function getMessages(JobApplication $application)
{
    return response()->json(
        $application->messages()->orderBy('created_at')->get()
    );
}



}
