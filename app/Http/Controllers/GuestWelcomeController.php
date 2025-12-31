<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GuestWelcomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view("users.guest.guestwelcome", compact("products"));
    }

    public function contact()
    {
        return view("users.contact.contact");
    }
}
