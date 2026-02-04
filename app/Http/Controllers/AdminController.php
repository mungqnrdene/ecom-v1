<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // WELCOME PAGE
    public function welcome()
    {
        $admin = Auth::guard('admin')->user();
        $categoriesForStrip = Category::withCount([
            'products as admin_products_count' => function ($query) use ($admin) {
                $query->where('admin_id', $admin->id);
            },
        ])->get();

        $categories = Category::with([
            'products' => function ($query) use ($admin) {
                $query->where('admin_id', $admin->id)->latest();
            },
        ])->get();

        return view('admin.welcome', compact('admin', 'categoriesForStrip', 'categories'));
    }

    // DASHBOARD PAGE
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $productQuery = Product::where('admin_id', $admin->id)->with('category');

        $productCount    = $productQuery->count();
        $latestProducts  = (clone $productQuery)->latest()->take(5)->get();
        $totalRevenue    = Order::sum('total_amount');
        $todayRevenue    = Order::whereDate('created_at', now())->sum('total_amount');
        $activeOrders    = Order::whereIn('status', ['pending', 'processing', 'shipped'])->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $customerCount   = User::count();

        return view('admin.dashboard', compact(
            'admin',
            'productCount',
            'latestProducts',
            'totalRevenue',
            'todayRevenue',
            'activeOrders',
            'completedOrders',
            'customerCount'
        ));
    }

    // REPORTS PAGE
    public function reports()
    {
        $admin          = Auth::guard('admin')->user();
        $totalRevenue   = Order::sum('total_amount');
        $todayRevenue   = Order::whereDate('created_at', now())->sum('total_amount');
        $totalOrders    = Order::count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $refundAmount   = Order::whereNotNull('refunded_at')->sum('total_amount');
        $refundedOrders = Order::whereNotNull('refunded_at')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        $topProducts = Product::where('admin_id', $admin->id)
            ->with('category')
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        return view('admin.reports', compact(
            'admin',
            'totalRevenue',
            'todayRevenue',
            'totalOrders',
            'averageOrderValue',
            'refundAmount',
            'refundedOrders',
            'recentOrders',
            'topProducts'
        ));
    }

    // ADMIN ORDERS MANAGEMENT
    public function orders()
    {
        $admin = Auth::guard('admin')->user();
        $orders = Order::with('user', 'orderItems')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('admin', 'orders'));
    }

    public function showOrder(Order $order)
    {
        $admin = Auth::guard('admin')->user();
        $order->load('user', 'orderItems.product');

        return view('admin.orders.show', compact('admin', 'order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        // If order is being confirmed (moved to processing), decrease product quantities
        if ($oldStatus === 'pending' && $newStatus === 'processing') {
            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    $product = $item->product;
                    $newQuantity = max(0, $product->quantity - $item->quantity);
                    $product->update(['quantity' => $newQuantity]);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Захиалгын төлөв амжилттай шинэчлэгдлээ.');
    }

    // SETTINGS PAGE
    public function settings()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings', compact('admin'));
    }

    public function updateSettings(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return back()->with('success', 'Тохиргоог амжилттай хадгаллаа.');
    }

    public function categoryProducts(Category $category)
    {
        $admin = Auth::guard('admin')->user();

        $products = Product::where('admin_id', $admin->id)
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(16);

        return view('admin.category-products', compact('admin', 'category', 'products'));
    }
}
