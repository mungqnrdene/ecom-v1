<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
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
        'profile',
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
            'profile' => $this->loadProfileData(),
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
        $categoryId = request()->input('category');
        $categories = Category::with(['products' => function ($query) {
            $query->latest();
        }])->orderBy('name')->get();

        $selectedCategory = $categoryId ? Category::find($categoryId) : null;

        // If a category is selected, filter categories
        if ($selectedCategory) {
            $categories = $categories->where('id', $categoryId);
        }

        return [
            'categories' => $categories,
            'allCategories' => Category::withCount('products')->orderBy('name')->get(),
            'selectedCategory' => $selectedCategory,
            'totalProducts' => Product::count(),
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
     * Load profile data (read-only view)
     */
    private function loadProfileData(): array
    {
        $user = Auth::user();
        $cartWithCount = $user->cart()->withCount('cartItems')->first();

        return [
            'user' => $user,
            'stats' => [
                'orders' => $user->orders()->count(),
                'wishlist' => $user->wishlistItems()->count(),
                'savedCards' => $user->savedCards()->count(),
                'cartItems' => $cartWithCount?->cart_items_count ?? 0,
            ],
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
