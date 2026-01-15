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

Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');
Route::get('/contactus', function () {
    return view('contactus');
})->name('contactus');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{id}/reviews', [ProductController::class, 'storeReview'])->name('products.reviews.store')->middleware('auth');

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
    Route::post('/dashboard/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/dashboard/change-password', [UserController::class, 'showChangePassword'])->name('password.change');
    Route::post('/dashboard/change-password', [UserController::class, 'changePassword'])->name('password.update');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
});

// Admin routes (simple closures for list/detail pages using models)
Route::prefix('/admin')->middleware(['auth','admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::get('/categories', function () {
        $categories = App\Models\Category::all();
        return view('admin.categories.index', compact('categories'));
    })->name('categories.index');

    Route::get('/categories/create', function () {
        $categories = App\Models\Category::all();
        return view('admin.categories.create', compact('categories'));
    })->name('categories.create');

    Route::post('/categories', function (Illuminate\Http\Request $request) {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,category_id',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        App\Models\Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    })->name('categories.store');

    Route::get('/categories/{category}/edit', function (App\Models\Category $category) {
        $categories = App\Models\Category::where('category_id','<>',$category->category_id)->get();
        return view('admin.categories.edit', compact('category','categories'));
    })->name('categories.edit');

    Route::put('/categories/{category}', function (Illuminate\Http\Request $request, App\Models\Category $category) {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,category_id',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    })->name('categories.update');

    Route::delete('/categories/{category}', function (App\Models\Category $category) {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    })->name('categories.destroy');

    // Products
    Route::get('/products', function () {
        $products = App\Models\Product::with('category')->paginate(20);
        return view('admin.products.index', compact('products'));
    })->name('products.index');

    // Brands management
    Route::get('/brands', function () {
        $brands = App\Models\Brand::all();
        return view('admin.brands.index', compact('brands'));
    })->name('brands.index');

    Route::get('/brands/create', function () {
        return view('admin.brands.create');
    })->name('brands.create');

    Route::post('/brands', function (Illuminate\Http\Request $request) {
        $data = $request->validate([
            'brand_name' => 'required|string|max:255',
            'country_origin' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
            'logo' => 'nullable|file|image|max:5120',
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/brands'), $filename);
            $data['logo_url'] = 'images/brands/' . $filename;
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        App\Models\Brand::create($data);
        return redirect()->route('admin.brands.index')->with('success', 'Brand created.');
    })->name('brands.store');

    Route::get('/brands/{brand}/edit', function (App\Models\Brand $brand) {
        return view('admin.brands.edit', compact('brand'));
    })->name('brands.edit');

    Route::put('/brands/{brand}', function (Illuminate\Http\Request $request, App\Models\Brand $brand) {
        $data = $request->validate([
            'brand_name' => 'required|string|max:255',
            'country_origin' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
            'logo' => 'nullable|file|image|max:5120',
        ]);
        if ($request->hasFile('logo')) {
            if ($brand->logo_url && file_exists(public_path($brand->logo_url))) {
                @unlink(public_path($brand->logo_url));
            }
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/brands'), $filename);
            $data['logo_url'] = 'images/brands/' . $filename;
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $brand->update($data);
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated.');
    })->name('brands.update');

    Route::delete('/brands/{brand}', function (App\Models\Brand $brand) {
        if ($brand->logo_url && file_exists(public_path($brand->logo_url))) {
            @unlink(public_path($brand->logo_url));
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted.');
    })->name('brands.destroy');

    Route::get('/products/create', function () {
        $categories = App\Models\Category::all();
        $brands = App\Models\Brand::all();
        return view('admin.products.form', compact('categories','brands'));
    })->name('products.create');

    Route::post('/products', function (Illuminate\Http\Request $request) {
        $data = $request->validate([
            'brand_id' => 'nullable|exists:brands,brand_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'product_code' => 'nullable|string|max:255',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'paint_base' => 'nullable|string|max:255',
            'finish_type' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
            'coverage_area' => 'nullable|string|max:255',
            'cost_price' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|integer',
            'low_stock_alert' => 'nullable|integer',
            'rating_avg' => 'nullable|numeric',
            'total_sold' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|file|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/products'), $filename);
            $data['image_url'] = 'images/products/' . $filename;
        }

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        App\Models\Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    })->name('products.store');

    Route::get('/products/{product}/edit', function (App\Models\Product $product) {
        $categories = App\Models\Category::all();
        $brands = App\Models\Brand::all();
        return view('admin.products.form', compact('product', 'categories','brands'));
    })->name('products.edit');

    Route::put('/products/{product}', function (Illuminate\Http\Request $request, App\Models\Product $product) {
        $data = $request->validate([
            'brand_id' => 'nullable|exists:brands,brand_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'product_code' => 'nullable|string|max:255',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'paint_base' => 'nullable|string|max:255',
            'finish_type' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
            'coverage_area' => 'nullable|string|max:255',
            'cost_price' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|integer',
            'low_stock_alert' => 'nullable|integer',
            'rating_avg' => 'nullable|numeric',
            'total_sold' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|file|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // remove old image if exists
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                @unlink(public_path($product->image_url));
            }

            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/products'), $filename);
            $data['image_url'] = 'images/products/' . $filename;
        }

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    })->name('products.update');

    Route::delete('/products/{product}', function (App\Models\Product $product) {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    })->name('products.destroy');

    Route::get('/orders', [DashboardController::class, 'indexOrder'])->name('orders.index');

    Route::get('/orders/{order}', function (App\Models\Order $order) {
        $order->load('orderItems.product');
        return view('admin.orders.show', compact('order'));
    })->name('orders.show');

    // Order actions: confirm / cancel
    Route::post('/orders/{order}/confirm', function (App\Models\Order $order) {
        $order->order_status = 'confirmed';
        $order->save();
        return redirect()->back()->with('success', 'Order confirmed.');
    })->name('orders.confirm');

    Route::post('/orders/{order}/cancel', function (App\Models\Order $order) {
        $order->order_status = 'cancelled';
        $order->save();
        return redirect()->back()->with('success', 'Order cancelled.');
    })->name('orders.cancel');

    Route::get('/users', function () {
        $users = App\Models\User::where('user_type', "customer")->paginate(20);
        return view('admin.users.index', compact('users'));
    })->name('users.index');

    Route::get('/users/{user}', function (App\Models\User $user) {
        $user->load('orders');
        return view('admin.users.show', compact('user'));
    })->name('users.show');

    Route::post('/users/{user}/toggle', function (App\Models\User $user) {
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'User status updated.');
    })->name('users.toggle');
    
    Route::post('/users/{user}/delete', function (App\Models\User $user) {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    })->name('users.delete');
});
