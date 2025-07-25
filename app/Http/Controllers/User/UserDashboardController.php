<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $applications = Auth::user()->applications()->with('job')->latest()->get();

        return view('user.dashboard', compact('applications'));
    }
}
