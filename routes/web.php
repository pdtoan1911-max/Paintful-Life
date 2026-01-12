<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');

// Auth routes (login/logout)
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () { return view('dashboard.index'); })->name('dashboard');
    Route::get('/dashboard', [UserController::class, 'profile'])->name('profile');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
});

// Admin routes (simple closures for list/detail pages using models)
Route::prefix('/admin')->middleware(['auth','admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/categories', function () {
        $categories = App\Models\Category::all();
        return view('admin.categories.index', compact('categories'));
    })->name('categories.index');

    Route::get('/categories/{category}/edit', function (App\Models\Category $category) {
        return view('admin.categories.edit', compact('category'));
    })->name('categories.edit');

    Route::put('/categories/{category}', function (Illuminate\Http\Request $request, App\Models\Category $category) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    })->name('categories.update');

    Route::delete('/categories/{category}', function (App\Models\Category $category) {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    })->name('categories.destroy');

    Route::get('/products', function () {
        $products = App\Models\Product::with('category')->paginate(20);
        return view('admin.products.index', compact('products'));
    })->name('products.index');

    Route::get('/products/create', function () {
        $categories = App\Models\Category::all();
        return view('admin.products.form', compact('categories'));
    })->name('products.create');

    Route::get('/products/{product}/edit', function (App\Models\Product $product) {
        $categories = App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    })->name('products.edit');

    Route::put('/products/{product}', function (Illuminate\Http\Request $request, App\Models\Product $product) {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    })->name('products.update');

    Route::delete('/products/{product}', function (App\Models\Product $product) {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    })->name('products.destroy');

    Route::get('/orders', function () {
        $orders = App\Models\Order::with('orderItems')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    })->name('orders.index');

    Route::get('/orders/{order}', function (App\Models\Order $order) {
        $order->load('orderItems');
        return view('admin.orders.show', compact('order'));
    })->name('orders.show');

    Route::get('/users', function () {
        $users = App\Models\User::paginate(20);
        return view('admin.users.index', compact('users'));
    })->name('users.index');
});
