<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GuestWelcomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(12)->get();
        return view("users.guest.guestwelcome", compact("products"));
    }
    public function indexApi()
    {
        $products = Product::latest()->take(12)->get();
        return response()->json($products);
    }

    public function contact()
    {
        return view("users.contact.contact");
    }
}
