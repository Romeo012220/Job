<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function jobApplications()
{
    // Load all job applications with related job info, ordered latest first
    $applications = \App\Models\JobApplication::with('job')->latest()->paginate(20);
    
    return view('admin.job-applications.index', compact('applications'));
}
}
