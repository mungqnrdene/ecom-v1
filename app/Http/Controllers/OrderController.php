<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        return view('users.checkout.order', compact('cart'));
    }

    public function store()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('welcome');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $total = $subtotal;

        Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
            'status'           => 'pending',
            'payment_status'   => 'pending',
            'subtotal'         => $subtotal,
            'shipping_cost'    => 0,
            'tax'              => 0,
            'total_amount'     => $total,
            'shipping_address' => 'Тодорхойгүй',
        ]);

        session()->forget('cart');

        return redirect()->route('users.welcome')
            ->with('success', 'Захиалга амжилттай үүслээ');
    }
}
