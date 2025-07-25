<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    
public function index(Request $request)
{
    $search = $request->input('search');

    $jobs = Job::when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%")
                             ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

    return view('jobs.index', compact('jobs', 'search'));
}




public function create()
{
    return view('admin.jobs.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        'salary' => 'nullable|numeric',
    ]);

    Job::create([
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'type' => $request->type,
        'salary' => $request->salary,
    ]);

    return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
}

}
