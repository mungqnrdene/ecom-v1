<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart()->with('cartItems.product')->first();
        $cartItems = $cart ? $cart->cartItems : collect();

        return view('users.shop.cart', compact('cartItems'));
    }

    public function add(Product $product)
    {
        // Check if product is out of stock
        if ($product->quantity <= 0) {
            return back()->with('error', 'Уучлаарай, энэ бараа дууссан байна.');
        }

        $cart = $this->getUserCart();
        $existingItem = $cart->cartItems()->where('product_id', $product->id)->first();

        // Check if adding one more would exceed stock
        if ($existingItem && $existingItem->quantity >= $product->quantity) {
            return back()->with('error', "Үлдэгдэл хүрэлцэхгүй байна. Зөвхөн {$product->quantity} ширхэг байна.");
        }

        $this->addProductToCart($product);

        return back()->with('success', 'Сагсанд нэмэгдлээ');
    }

    public function buyNow(Product $product)
    {
        // Check if product is out of stock
        if ($product->quantity <= 0) {
            return back()->with('error', 'Уучлаарай, энэ бараа дууссан байна.');
        }

        $cart = $this->getUserCart();
        $existingItem = $cart->cartItems()->where('product_id', $product->id)->first();

        // Check if adding one more would exceed stock
        if ($existingItem && $existingItem->quantity >= $product->quantity) {
            return back()->with('error', "Үлдэгдэл хүрэлцэхгүй байна. Зөвхөн {$product->quantity} ширхэг байна.");
        }

        $this->addProductToCart($product);

        return redirect()->route('order.create')->with('success', 'Сагснаас худалдан авахад бэлэн.');
    }

    public function updateQuantity(Product $product)
    {
        $quantity = request()->input('quantity', 1);

        if ($quantity < 1) {
            return back()->with('error', 'Тоо ширхэг 1-ээс багагүй байх ёстой.');
        }

        if ($quantity > $product->quantity) {
            return back()->with('error', "Үлдэгдэл хүрэлцэхгүй байна. Зөвхөн {$product->quantity} ширхэг байна.");
        }

        $cart = $this->getUserCart();
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->total_price = $quantity * $cartItem->unit_price;
            $cartItem->save();

            $this->syncTotals($cart);

            return back()->with('success', 'Тоо ширхэг шинэчлэгдлээ');
        }

        return back()->with('error', 'Бараа олдсонгүй');
    }

    public function moveFromWishlist(Product $product)
    {
        $this->addProductToCart($product);
        $this->removeFromWishlist($product);

        return back()->with('success', 'Хадгалсан барааг сагс руу шилжүүллээ.');
    }

    public function buyFromWishlist(Product $product)
    {
        $this->addProductToCart($product);
        $this->removeFromWishlist($product);

        return redirect()->route('order.create')->with('success', 'Сагснаас худалдан авахад бэлэн.');
    }

    public function remove(Product $product)
    {
        $cart = Auth::user()->cart;

        if ($cart) {
            $cart->cartItems()->where('product_id', $product->id)->delete();
            $this->syncTotals($cart);
        }

        return back();
    }

    public function clear()
    {
        $cart = Auth::user()->cart;

        if ($cart) {
            $cart->cartItems()->delete();
            $cart->update([
                'total_items' => 0,
                'total_price' => 0,
            ]);
        }

        return redirect()->route('cart.index');
    }

    protected function getUserCart(): Cart
    {
        return Auth::user()->cart()->firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    protected function syncTotals(Cart $cart): void
    {
        $totals = $cart->cartItems()
            ->selectRaw('COALESCE(SUM(quantity), 0) as items, COALESCE(SUM(total_price), 0) as amount')
            ->first();

        $cart->update([
            'total_items' => (int) $totals->items,
            'total_price' => (float) $totals->amount,
        ]);
    }

    protected function addProductToCart(Product $product, int $quantity = 1): Cart
    {
        $cart = $this->getUserCart();

        $cartItem = $cart->cartItems()->firstOrNew([
            'product_id' => $product->id,
        ]);

        $newQuantity = $cartItem->exists ? $cartItem->quantity + $quantity : $quantity;

        // Check if adding would exceed available stock
        if ($newQuantity > $product->quantity) {
            $availableQty = max(0, $product->quantity - ($cartItem->quantity ?? 0));
            if ($availableQty > 0) {
                $cartItem->quantity = $product->quantity;
            } else {
                return $cart; // Cannot add more, stock is exhausted
            }
        } else {
            $cartItem->quantity = $newQuantity;
        }

        $cartItem->unit_price = $product->price;
        $cartItem->total_price = $cartItem->quantity * $cartItem->unit_price;
        $cartItem->save();

        $this->syncTotals($cart);

        return $cart;
    }

    protected function removeFromWishlist(Product $product): void
    {
        WishlistItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();
    }
}
