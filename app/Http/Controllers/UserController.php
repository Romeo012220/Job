<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $applicationsCount = JobApplication::where('user_id', $user->id)->count();

        return view('user.dashboard', compact('user', 'applicationsCount'));
    }

public function dashboard()
{
    $user = auth()->user();

    // Make sure User model has applications() relationship
    $applications = $user->applications()->with('job')->latest()->get();

    return view('user.dashboard', compact('applications'));
}

}


