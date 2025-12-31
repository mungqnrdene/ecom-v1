<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // WELCOME PAGE
    public function welcome()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.welcome', compact('admin'));
    }

    // DASHBOARD PAGE
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard', compact('admin'));
    }
}
