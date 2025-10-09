<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ----------------------
    // Login хэсэг
    // ----------------------

    public function showLoginForm()
    {
        return view('admin.login'); // resources/views/admin/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate(); // 🛡 Security
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Имэйл эсвэл нууц үг буруу байна.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // ----------------------
    // Register хэсэг
    // ----------------------

    public function showRegisterForm()
    {
        return view('admin.register'); // resources/views/admin/register.blade.php
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = new Admin();
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->password = Hash::make($validated['password']); // 🛠 Hash::make()
        $admin->save();

        Auth::guard('admin')->login($admin); // шууд login хийнэ
        $request->session()->regenerate();   // 🛡 session шинэчилнэ

        return redirect('/admin/dashboard');
    }
}
