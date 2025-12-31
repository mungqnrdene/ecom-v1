<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // USER HOME
    public function index()
    {
        $products = Product::latest()->get();
        return view('users.shop.dashboard', compact('products'));
    }

    // LOGIN PAGE
    public function showLogin()
    {
        return view('users.auth.login');
    }

    // LOGIN SUBMIT
    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('users.welcome');
        }

        return back()->withErrors([
            'email' => 'Имэйл эсвэл нууц үг буруу байна',
        ]);
    }

    // REGISTER PAGE
    public function showRegister()
    {
        return view('users.auth.register');
    }

    // REGISTER SUBMIT
    public function submitRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('users.welcome');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('users.login');
    }

    // PRODUCTS PAGE
    public function products()
    {
        $products = Product::latest()->paginate(12);
        return view('users.shop.products', compact('products'));
    }

    // WISHLIST PAGE
    public function wishlist()
    {
        return view('users.shop.wishlist');
    }

    // PAYMENT CARD PAGE
    public function paymentCard()
    {
        return view('users.checkout.payment-card');
    }

    // QPAY PAGE
    public function qpay()
    {
        return view('users.checkout.qpay');
    }

    // CONTACT PAGE
    public function contactPage()
    {
        return view('users.contact.contact');
    }
}
