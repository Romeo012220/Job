<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use App\Models\QuestionGroup;

class JobController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $jobs = Job::with('questionGroup.questions') // Eager load questions
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%")
                         ->orWhere('location', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

    return view('jobs.index', compact('jobs', 'search'));
}



public function edit($id)
{
    $job = Job::with('questionGroup')->findOrFail($id);
    $questionGroups = \App\Models\QuestionGroup::all(); // also pass all groups for the dropdown
    return view('admin.jobs.editjobposted', compact('job', 'questionGroups'));
}



public function create()
{
    $questionGroups = QuestionGroup::all();
    return view('admin.jobs.create', compact('questionGroups'));
}
public function store(Request $request)
{
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'location' => 'required|string|max:255',
    'question_group_id' => 'nullable|exists:question_groups,id',
    'education' => 'required',
    'job_type' => 'required|string|max:100', // ✅ use this instead
    'qualifications' => 'nullable',
]);


Job::create([
    'title' => $request->title,
    'description' => $request->description,
    'location' => $request->location,
    'type' => $request->job_type, // fixed
    'question_group_id' => $request->question_group_id,
    'education' => $request->education,
    'job_type' => $request->job_type,
    'qualifications' => $request->qualifications,
      'category' => $request->category, // 👈 add this
]);



    // Role-based redirect
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.jobs.index')->with('success', 'Job posted successfully!');
    }

    return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
}
public function adminIndex()
{
    $jobs = Job::latest()->paginate(10); // You can use ->get() instead of paginate if you want
    return view('admin.jobs.index', compact('jobs'));
}


// JobController.php
public function show($id)
{
    $job = Job::with('questionGroup.questions')->findOrFail($id);

    $alreadyApplied = false;
    if (auth()->check()) {
        $alreadyApplied = $job->applications()
            ->where('user_id', auth()->id())
            ->exists();
    }

    // ✅ Change the view path to your actual view file
    return view('admin.jobs.showjobinfo', compact('job', 'alreadyApplied'));
}






public function update(Request $request, $id)
{
    $job = Job::findOrFail($id);

    $job->update([
        'title' => $request->title,
        'type' => $request->type,
        'location' => $request->location,
        'description' => $request->description,
         'education' => $request->education,
    'job_type' => $request->job_type,
    'qualifications' => $request->qualifications,
     'category' => $request->category, // 👈 add this

    ]);

    return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully.');
}

public function closeJob(Job $job)
{
    $job->status = 'closed';
    $job->save();

    return redirect()->back()->with('success', 'Job has been closed successfully.');
}

public function viewJobPost($id)
{
    $job = Job::with('questionGroup.questions')->findOrFail($id);

    $alreadyApplied = false;

    if (Auth::check()) {
        $alreadyApplied = JobApplication::where('job_id', $job->id)
                                        ->where('user_id', Auth::id())
                                        ->exists();
    }

    return view('jobs.view', compact('job', 'alreadyApplied'));
}


//reopen closed job
public function reopen($id)
{
    $job = Job::findOrFail($id);
    $job->status = 'open';
    $job->save();

    return redirect()->back()->with('success', 'Job successfully reopened.');
}



}
