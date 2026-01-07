<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WishlistItem;
use App\Support\Concerns\HandlesAuthIdentifiers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    use HandlesAuthIdentifiers;
    // USER HOME
    public function index(Request $request)
    {
        $searchQuery = $request->input('q', '');
        $isSearching = !empty($searchQuery);

        // Search products if query exists
        if ($isSearching) {
            $products = Product::with('category')
                ->where('name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('description', 'LIKE', "%{$searchQuery}%")
                ->orWhere('keywords', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('category', function ($q) use ($searchQuery) {
                    $q->where('name', 'LIKE', "%{$searchQuery}%");
                })
                ->latest()
                ->get();
        } else {
            // Show latest products by default
            $products = Product::with('category')->latest()->get();
        }

        return view('users.shop.dashboard', compact('products', 'searchQuery', 'isSearching'));
    }

    // LOGIN PAGE
    public function showLogin()
    {
        return view('users.auth.login', [
            'rememberedLogin' => $this->getRememberedLoginValue(),
        ]);
    }

    // LOGIN SUBMIT
    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $remember = $request->boolean('remember');
        $resolved = $this->resolveIdentifier($credentials['identifier']);
        $throttleKey = sprintf('login:%s', $resolved['value']);

        $this->ensureNotRateLimited($throttleKey, 5, 'identifier');

        if (Auth::guard('web')->attempt([
            $resolved['field'] => $resolved['value'],
            'password'          => $credentials['password'],
        ], $remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $user = Auth::user();
            $user->last_login_at = now();
            $user->last_login_ip = $request->ip();
            $user->save();

            if ($remember) {
                Cookie::queue('remembered_login', Crypt::encryptString($credentials['identifier']), 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('remembered_login'));
            }

            return redirect()->route('users.welcome');
        }

        RateLimiter::hit($throttleKey);

        return back()->withErrors([
            'identifier' => 'Нэвтрэх мэдээлэл буруу байна.',
        ])->withInput($request->only('identifier'));
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
            'phone' => 'nullable|string|max:20|required_without:email',
            'email' => 'nullable|email|max:255|required_without:phone|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'phone.required_without' => 'Имэйл эсвэл утасны дугаарын нэгийг заавал оруулна уу.',
            'email.required_without' => 'Имэйл эсвэл утасны дугаарын нэгийг заавал оруулна уу.',
        ]);

        $phone = $validated['phone'] ? $this->normalizePhone($validated['phone']) : null;

        if ($validated['phone'] && !$phone) {
            throw ValidationException::withMessages([
                'phone' => 'Утасны дугаарыг зөв форматаар оруулна уу.',
            ]);
        }

        if ($phone && User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages([
                'phone' => 'Энэ утасны дугаараар бүртгэл аль хэдийн бий.',
            ]);
        }

        $email = $validated['email'] ? Str::lower($validated['email']) : null;

        $request->session()->forget([
            'pending_registration',
            'pending_registration_identifier',
            'pending_registration_channel',
        ]);

        $request->session()->put('pending_registration', [
            'name' => $validated['name'],
            'phone' => $phone,
            'email' => $email,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.register.otp.channel')
            ->with('status', 'Баталгаажуулах кодыг авах сувгаа сонгоно уу.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget('remembered_login'));

        return redirect()->route('users.login');
    }

    // FORGOT PASSWORD PAGE
    public function showForgotPassword()
    {
        return view('users.auth.forgot-password');
    }

    // SEARCH PRODUCTS
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['products' => []]);
        }

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price_formatted' => number_format($product->price),
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                ];
            });

        return response()->json(['products' => $products]);
    }

    // PRODUCTS PAGE
    public function products()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(12);
        return view('users.shop.products', compact('products'));
    }

    // WISHLIST PAGE
    public function wishlist()
    {
        $wishlistItems = WishlistItem::with('product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('users.shop.wishlist', compact('wishlistItems'));
    }

    public function addToWishlist(Product $product)
    {
        WishlistItem::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Барааг хадгалсан жагсаалтад нэмлээ.');
    }

    public function removeFromWishlist(Product $product)
    {
        WishlistItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Барааг хадгалсан жагсаалтаас хаслаа.');
    }

    // PAYMENT CARD PAGE
    public function paymentCard()
    {
        $summary = $this->buildCartSummary();

        return view('users.checkout.payment-card', $summary);
    }

    public function processCardPayment(Request $request)
    {
        $summary = $this->buildCartSummary();

        if ($summary['cartItems']->isEmpty()) {
            return back()->withErrors([
                'cart' => 'Сагс хоосон байна. Эхлээд бараа нэмнэ үү.',
            ]);
        }

        $request->validate([
            'card_name'   => 'required|string|max:255',
            'card_number' => ['required', 'regex:/^[0-9 ]{16,19}$/'],
            'expiry'      => ['required', 'regex:/^(0[1-9]|1[0-2])\/(\d{2})$/'],
            'cvv'         => 'required|digits_between:3,4',
            'save_card'   => 'nullable|boolean',
        ], [
            'card_number.regex' => 'Картын дугаарыг зөвхөн тоогоор (16-19 орон) оруулна уу.',
            'expiry.regex'      => 'Хүчинтэй хугацааг MM/YY форматаар оруулна уу.',
        ]);

        $reference = 'CARD-' . Str::upper(Str::random(8));

        return redirect()->route('users.payment-card')->with([
            'success'            => 'Таны картын мэдээллийг хүлээн авлаа. Баталгаажуулалтын дараа төлбөрийг идэвхжүүлнэ.',
            'payment_reference'  => $reference,
        ]);
    }

    // SETTINGS PAGE
    public function settings()
    {
        return view('users.settings.profile');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'nullable|email|unique:users,email,' . $user->id,
            'phone'            => 'required|string|max:20',
            'city'             => 'nullable|string|max:100',
            'district'         => 'nullable|string|max:100',
            'address'          => 'nullable|string|max:500',
            'apartment_number' => 'nullable|string|max:50',
            'profile_picture'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $phone = $this->normalizePhone($validated['phone']);

        if (!$phone) {
            throw ValidationException::withMessages([
                'phone' => 'Утасны дугаарыг зөв форматаар оруулна уу.',
            ]);
        }

        if (User::where('phone', $phone)->where('id', '!=', $user->id)->exists()) {
            throw ValidationException::withMessages([
                'phone' => 'Энэ утасны дугаараар бүртгэл аль хэдийн бий.',
            ]);
        }

        $validated['phone'] = $phone;
        $validated['email'] = $validated['email'] ? Str::lower($validated['email']) : null;

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                \Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Профайл амжилттай шинэчлэгдлээ.');
    }

    // CONTACT PAGE
    public function contactPage()
    {
        return view('users.contact.contact');
    }

    protected function buildCartSummary(): array
    {
        $cart = Auth::user()->cart()->with('cartItems.product')->first();
        $cartItems = $cart ? $cart->cartItems : collect();
        $cartTotal = $cartItems->sum('total_price');

        return [
            'cart'      => $cart,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ];
    }

    protected function getRememberedLoginValue(): ?string
    {
        $rememberCookie = Cookie::get('remembered_login');

        if (!$rememberCookie) {
            return null;
        }

        try {
            return Crypt::decryptString($rememberCookie);
        } catch (\Throwable $th) {
            Cookie::queue(Cookie::forget('remembered_login'));

            return null;
        }
    }
}
