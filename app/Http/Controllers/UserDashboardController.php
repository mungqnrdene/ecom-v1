<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Allowed dashboard sections
     */
    private const ALLOWED_SECTIONS = [
        'dashboard',
        'products',
        'wishlist',
        'cart',
        'orders',
        'payment',
        'settings',
        'contact',
    ];

    /**
     * Display the dashboard with specific section
     */
    public function index(?string $section = null)
    {
        // Default to dashboard if no section provided
        $section = $section ?? 'dashboard';

        // Validate section
        if (!in_array($section, self::ALLOWED_SECTIONS)) {
            abort(404);
        }

        // Load data based on section
        $data = $this->loadSectionData($section);

        return view('users.dashboard.index', [
            'section' => $section,
            'data' => $data,
        ]);
    }

    /**
     * Load data for specific section
     */
    private function loadSectionData(string $section): array
    {
        return match ($section) {
            'dashboard' => $this->loadDashboardData(),
            'products' => $this->loadProductsData(),
            'wishlist' => $this->loadWishlistData(),
            'cart' => $this->loadCartData(),
            'orders' => $this->loadOrdersData(),
            'payment' => $this->loadPaymentData(),
            'settings' => $this->loadSettingsData(),
            'contact' => $this->loadContactData(),
            default => [],
        };
    }

    /**
     * Load dashboard data
     */
    private function loadDashboardData(): array
    {
        $searchQuery = request()->input('q', '');
        $isSearching = !empty($searchQuery);

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
            $products = Product::with('category')->latest()->get();
        }

        return [
            'products' => $products,
            'searchQuery' => $searchQuery,
            'isSearching' => $isSearching,
        ];
    }

    /**
     * Load products data
     */
    private function loadProductsData(): array
    {
        return [
            'products' => Product::with('category')->latest()->paginate(12),
        ];
    }

    /**
     * Load wishlist data
     */
    private function loadWishlistData(): array
    {
        return [
            'wishlistItems' => WishlistItem::with('product.category')
                ->where('user_id', Auth::id())
                ->latest()
                ->get(),
        ];
    }

    /**
     * Load cart data
     */
    private function loadCartData(): array
    {
        $cart = Auth::user()->cart()->with('cartItems.product')->first();
        $cartItems = $cart ? $cart->cartItems : collect();

        return [
            'cart' => $cart,
            'cartItems' => $cartItems,
        ];
    }

    /**
     * Load orders data
     */
    private function loadOrdersData(): array
    {
        return [
            'orders' => Auth::user()->orders()->with('orderItems.product')->latest()->paginate(10),
        ];
    }

    /**
     * Load payment data
     */
    private function loadPaymentData(): array
    {
        return [
            'savedCards' => Auth::user()->savedCards()->orderBy('is_default', 'desc')->get(),
        ];
    }

    /**
     * Load settings data
     */
    private function loadSettingsData(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }

    /**
     * Load contact data
     */
    private function loadContactData(): array
    {
        return [];
    }
}
