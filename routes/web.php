<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Admin Login form-ийг үзүүлэх route
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');

// Login form-оор орж submit хийхэд ажиллах route
Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

// Register буюу шинэ хэрэглэгч бүртгэх form үзүүлэх route
Route::get('/register', [AdminController::class, 'showRegisterForm'])->name('register');

// Register form-аас ирсэн өгөгдлийг хадгалах route
Route::post('/register', [AdminController::class, 'register'])->name('register.submit');

// Admin dashboard хуудас руу шилжих route
Route::get('/admin/dashboard', function() {
    return view('admin.dashboard');  // Энэ view-г өөрийн тохируулсан dashboard-тайгаа солих
})->middleware('auth:admin')->name('admin.dashboard');

// Logout
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
