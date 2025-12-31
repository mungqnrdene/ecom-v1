<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestWelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= PUBLIC / GUEST =================
Route::get('/', [GuestWelcomeController::class, 'index'])->name('welcome');
Route::get('/contact', [GuestWelcomeController::class, 'contact'])->name('contact');
Route::get('/products', [UsersController::class, 'products'])->name('products');

// ================= USER AUTH =================
Route::middleware('guest:web')->group(function () {
    Route::get('/users/login', [UsersController::class, 'showLogin'])->name('users.login');
    Route::post('/users/login', [UsersController::class, 'submitLogin'])->name('users.login.submit');

    Route::get('/users/register', [UsersController::class, 'showRegister'])->name('users.register');
    Route::post('/users/register', [UsersController::class, 'submitRegister'])->name('users.register.submit');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/users/dashboard', [UsersController::class, 'index'])->name('users.welcome');
    Route::post('/users/logout', [UsersController::class, 'logout'])->name('users.logout');

    // ===== USER PAGES =====
    Route::get('/users/wishlist', [UsersController::class, 'wishlist'])->name('users.wishlist');
    Route::get('/users/payment-card', [UsersController::class, 'paymentCard'])->name('users.payment-card');
    Route::get('/users/qpay', [UsersController::class, 'qpay'])->name('users.qpay');
    Route::get('/users/contact', [UsersController::class, 'contactPage'])->name('users.contact');

    // ===== CART =====
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // ===== ORDER =====
    Route::get('/checkout', [OrderController::class, 'create'])->name('order.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
});

// ================= ADMIN AUTH =================
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'submit'])->name('admin.login.submit');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/welcome', [AdminController::class, 'welcome'])->name('admin.welcome');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/products', ProductController::class)->names('admin.products');
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
