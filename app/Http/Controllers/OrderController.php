<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create()
    {
        $cart = Auth::user()->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $cartItems = $cart->cartItems;
        $user = Auth::user();
        $savedCards = Auth::user()->savedCards()->orderBy('is_default', 'desc')->get();

        // Get payment method settings
        $paymentMethods = [
            'card' => setting('card_enabled', 1) == 1,
            'cod' => setting('cod_enabled', 1) == 1,
        ];

        return view('users.checkout.order', compact('cartItems', 'user', 'savedCards', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        // Build allowed payment methods based on settings
        $allowedMethods = [];
        if (setting('card_enabled', 1) == 1) {
            $allowedMethods[] = 'card';
        }
        if (setting('cod_enabled', 1) == 1) {
            $allowedMethods[] = 'cash_on_delivery';
        }

        if (empty($allowedMethods)) {
            return back()->withErrors(['payment_method' => 'Төлбөрийн арга идэвхгүй байна. Админ тал дээр тохиргоо хийнэ үү.']);
        }

        $validated = $request->validate([
            'phone'            => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'payment_method'   => 'required|in:' . implode(',', $allowedMethods),
            'notes'            => 'nullable|string|max:1000',
        ], [
            'phone.required'            => 'Утасны дугаар заавал оруулна уу.',
            'shipping_address.required' => 'Хүргэлтийн хаяг заавал оруулна уу.',
            'payment_method.required'   => 'Төлбөрийн хэлбэр сонгоно уу.',
            'payment_method.in'         => 'Буруу төлбөрийн хэлбэр сонгосон байна.',
        ]);

        $cart = Auth::user()->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('welcome')->withErrors(['cart' => 'Сагс хоосон байна.']);
        }

        DB::beginTransaction();

        try {
            $subtotal = $cart->cartItems->sum('total_price');
            $total = $subtotal;

            // Determine initial order status based on payment method
            $initialStatus = 'pending';
            $paymentStatus = 'pending';

            $order = Order::create([
                'user_id'          => Auth::id(),
                'order_number'     => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
                'status'           => $initialStatus,
                'payment_status'   => $paymentStatus,
                'payment_method'   => $validated['payment_method'],
                'subtotal'         => $subtotal,
                'shipping_cost'    => 0,
                'tax'              => 0,
                'total_amount'     => $total,
                'shipping_address' => $validated['shipping_address'],
                'phone'            => $validated['phone'],
                'notes'            => $validated['notes'] ?? null,
            ]);

            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $cartItem->product_id,
                    'product_name'       => $cartItem->product->name ?? 'Unknown Product',
                    'price_at_purchase'  => $cartItem->unit_price,
                    'quantity'           => $cartItem->quantity,
                    'subtotal'           => $cartItem->total_price,
                ]);
            }

            $cart->cartItems()->delete();
            $cart->update([
                'total_items' => 0,
                'total_price' => 0,
            ]);

            DB::commit();

            // Redirect to payment based on method
            return $this->redirectToPayment($order, $validated['payment_method']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Захиалга үүсгэхэд алдаа гарлаа: ' . $e->getMessage()]);
        }
    }

    /**
     * Redirect to appropriate payment page
     */
    protected function redirectToPayment(Order $order, string $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'card':
                return redirect()->route('payment.card', ['order' => $order->id])
                    ->with('success', 'Захиалга үүслээ. Төлбөр төлнө үү.');

            case 'cash_on_delivery':
                // For cash on delivery, mark as processing immediately
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'pending_payment',
                ]);

                return redirect()->route('users.orders.show', ['order' => $order->id])
                    ->with('success', 'Захиалга амжилттай үүслээ. Бараа хүргэхдээ төлбөр төлнө үү.');

            default:
                return redirect()->route('users.orders')
                    ->with('success', 'Захиалга үүслээ.');
        }
    }

    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('users.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('users.orders.show', compact('order'));
    }

    public function refund(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'refunded') {
            return back()->withErrors(['error' => 'Энэ захиалга аль хэдийн буцаагдсан байна.']);
        }

        // Check 5-minute refund window
        $refundDeadline = $order->created_at->copy()->addMinutes(5);
        if (now()->greaterThan($refundDeadline)) {
            return back()->withErrors(['error' => 'Буцаалтын хугацаа дууссан байна. Захиалга үүссэнээс хойш зөвхөн 5 минутын дотор буцаалт хийх боломжтой.']);
        }

        $order->update([
            'status'         => 'refunded',
            'payment_status' => 'refunded',
            'refunded_at'    => now(),
        ]);

        return back()->with('success', 'Захиалгыг амжилттай буцаалаа.');
    }
}
