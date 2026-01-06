<?php
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;

Route::get('/', function () {
return view('welcome');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth:admin'])->group(function () {
Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
});

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login']);
Route::get('/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register']);

Route::middleware(['auth:customer'])->group(function () {
Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});
});

// Admin Product Routes
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::resource('products', App\Http\Controllers\ProductController::class);
});
Route::post('admin/products/import', [App\Http\Controllers\ProductController::class, 'import'])->name('admin.products.import')->middleware('auth:admin');
