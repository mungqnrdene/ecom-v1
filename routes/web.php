<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\GuestWelcomeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegistrationOtpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SavedCardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= PUBLIC / GUEST =================
Route::get('/', [GuestWelcomeController::class, 'index'])->name('welcome');
Route::get('/contact', [GuestWelcomeController::class, 'contact'])->name('contact');
Route::get('/products', [UserDashboardController::class, 'index'])->defaults('section', 'products')->name('products');

// ================= USER AUTH =================
Route::middleware('guest:web')->group(function () {
    Route::get('/users/login', [UsersController::class, 'showLogin'])->name('users.login');
    Route::post('/users/login', [UsersController::class, 'submitLogin'])->name('users.login.submit');

    Route::get('/users/register', [UsersController::class, 'showRegister'])->name('users.register');
    Route::post('/users/register', [UsersController::class, 'submitRegister'])->name('users.register.submit');

    Route::get('/users/register/otp-channel', [RegistrationOtpController::class, 'showChannelForm'])->name('users.register.otp.channel');
    Route::post('/users/register/otp-send', [RegistrationOtpController::class, 'send'])->name('users.register.otp.send');
    Route::get('/users/register/otp-verify', [RegistrationOtpController::class, 'showVerifyForm'])->name('users.register.otp.verify.form');
    Route::post('/users/register/otp-verify', [RegistrationOtpController::class, 'verify'])->name('users.register.otp.verify');
    Route::post('/users/register/otp-resend', [RegistrationOtpController::class, 'resend'])->name('users.register.otp.resend');

    Route::get('/users/forgot-password', [UsersController::class, 'showForgotPassword'])->name('users.password.request');
    Route::post('/otp/request', [OtpController::class, 'request'])->name('otp.request');
    Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
    Route::get('/otp/reset-password', [OtpController::class, 'showResetForm'])->name('otp.reset.form');
    Route::post('/otp/reset-password', [OtpController::class, 'resetPassword'])->name('otp.reset');
});

Route::middleware('auth:web')->group(function () {
    // ===== UNIFIED DASHBOARD =====
    Route::get('/users/dashboard/{section?}', [UserDashboardController::class, 'index'])->name('users.dashboard');

    Route::post('/users/logout', [UsersController::class, 'logout'])->name('users.logout');

    // ===== SEARCH ===== 
    Route::get('/users/search', [ProductController::class, 'search'])->name('users.search');
    Route::get('/users/wishlist', [UsersController::class, 'wishlist'])->name('users.wishlist');

    // ===== USER ACTIONS (POST/PATCH/DELETE only) =====
    Route::post('/users/wishlist/add/{product}', [UsersController::class, 'addToWishlist'])->name('users.wishlist.add');
    Route::delete('/users/wishlist/{product}', [UsersController::class, 'removeFromWishlist'])->name('users.wishlist.remove');
    Route::patch('/users/settings', [UsersController::class, 'updateSettings'])->name('users.settings.update');
    Route::post('/users/payment-card', [UsersController::class, 'processCardPayment'])->name('users.payment-card.submit');

    // ===== CART =====
    Route::get('/cart', fn() => redirect()->route('users.dashboard', 'cart'))->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/wishlist/{product}/move', [CartController::class, 'moveFromWishlist'])->name('cart.wishlist.move');
    Route::post('/cart/wishlist/{product}/buy', [CartController::class, 'buyFromWishlist'])->name('cart.wishlist.buy');

    // ===== ORDER =====
    Route::get('/users/orders', fn() => redirect()->route('users.dashboard', 'orders'))->name('users.orders');
    Route::get('/checkout', [OrderController::class, 'create'])->name('order.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
    Route::get('/users/orders/{order}', [OrderController::class, 'show'])->name('users.orders.show');
    Route::patch('/users/orders/{order}/refund', [OrderController::class, 'refund'])->name('users.orders.refund');

    // ===== PAYMENT =====
    Route::get('/payment/card/{order}', [PaymentController::class, 'showCardPayment'])->name('payment.card');
    Route::post('/payment/card/{order}', [PaymentController::class, 'processCardPayment'])->name('payment.card.process');

    // ===== SAVED CARDS =====
    Route::get('/users/saved-cards', [SavedCardController::class, 'index'])->name('users.saved-cards');
    Route::post('/users/saved-cards', [SavedCardController::class, 'store'])->name('users.saved-cards.store');
    Route::patch('/users/saved-cards/{id}/default', [SavedCardController::class, 'setDefault'])->name('users.saved-cards.default');
    Route::delete('/users/saved-cards/{id}', [SavedCardController::class, 'destroy'])->name('users.saved-cards.destroy');

    // Legacy route names for backward compatibility
    Route::permanentRedirect('/users/welcome', '/users/dashboard')->name('users.welcome');
});

// ================= ADMIN AUTH =================
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'submit'])->name('admin.login.submit');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/welcome', [AdminController::class, 'welcome'])->name('admin.welcome');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Reports
    Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports');
    Route::get('/admin/reports/export/10-days', [AdminReportController::class, 'export10Days'])->name('admin.reports.export.10days');
    Route::get('/admin/reports/export/monthly', [AdminReportController::class, 'exportMonthly'])->name('admin.reports.export.monthly');
    Route::get('/admin/reports/export/users', [AdminReportController::class, 'exportUsers'])->name('admin.reports.export.users');
    Route::get('/admin/reports/export/orders', [AdminReportController::class, 'exportOrders'])->name('admin.reports.export.orders');
    Route::get('/admin/reports/export/refunds', [AdminReportController::class, 'exportRefunds'])->name('admin.reports.export.refunds');

    // Admin Settings
    Route::get('/admin/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
    Route::patch('/admin/settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('admin.settings.profile');
    Route::patch('/admin/settings/password', [AdminSettingsController::class, 'updatePassword'])->name('admin.settings.password');
    Route::patch('/admin/settings/store', [AdminSettingsController::class, 'updateStore'])->name('admin.settings.store');
    Route::patch('/admin/settings/payment', [AdminSettingsController::class, 'updatePayment'])->name('admin.settings.payment');
    Route::patch('/admin/settings/order', [AdminSettingsController::class, 'updateOrder'])->name('admin.settings.order');
    Route::patch('/admin/settings/security', [AdminSettingsController::class, 'updateSecurity'])->name('admin.settings.security');

    Route::resource('/admin/products', ProductController::class)->names('admin.products');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
