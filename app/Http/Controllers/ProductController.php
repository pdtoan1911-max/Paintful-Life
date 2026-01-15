<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $baseQuery = Product::query()
            ->where('is_active', 1);

        if ($request->filled('category')) {
            $baseQuery->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $baseQuery->where('price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $baseQuery->where('price', '<=', (int) $request->max_price);
        }

        if ($request->filled('volume')) {
            $baseQuery->whereIn('volume', (array) $request->volume);
        }

        if ($request->filled('finish')) {
            $baseQuery->whereIn('finish_type', (array) $request->finish);
        }

        $products = (clone $baseQuery)
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $volumes = (clone $baseQuery)
            ->whereNotNull('volume')
            ->distinct()
            ->orderBy('volume')
            ->pluck('volume');

        $finishes = (clone $baseQuery)
            ->whereNotNull('finish_type')
            ->distinct()
            ->orderBy('finish_type')
            ->pluck('finish_type');

        $categories = Category::where('is_active', 1)
            ->orderBy('category_name')
            ->get();

        $suggested = Product::where('is_active', 1)
            ->where('is_featured', 1)
            ->latest()
            ->limit(8)
            ->get();

        return view('products.index', compact(
            'products',
            'categories',
            'volumes',
            'finishes',
            'suggested'
        ));
    }



    public function show($id)
    {
        $product = Product::findOrFail($id);
        $related = Product::query()
            ->select('products.*')
            ->selectRaw('
        COALESCE(purchased_together.qty, 0) * 3 +
        COALESCE(products.rating_avg, 0) * 2 +
        COALESCE(sold_stats.sold_qty, 0) * 1
        AS relevance_score
    ')

            ->leftJoinSub(
                DB::table('order_items as oi1')
                    ->select('oi2.product_id', DB::raw('COUNT(*) as qty'))
                    ->join('orders', 'orders.order_id', '=', 'oi1.order_id')
                    ->join('order_items as oi2', 'oi1.order_id', '=', 'oi2.order_id')
                    ->where('orders.order_status', 'confirmed')
                    ->where('oi1.product_id', $product->product_id)
                    ->whereColumn('oi2.product_id', '<>', 'oi1.product_id')
                    ->groupBy('oi2.product_id'),
                'purchased_together',
                'purchased_together.product_id',
                '=',
                'products.product_id'
            )

            ->leftJoinSub(
                DB::table('order_items')
                    ->select(
                        'order_items.product_id',
                        DB::raw('SUM(order_items.quantity) as sold_qty')
                    )
                    ->join('orders', 'orders.order_id', '=', 'order_items.order_id')
                    ->where('orders.order_status', 'confirmed')
                    ->groupBy('order_items.product_id'),
                'sold_stats',
                'sold_stats.product_id',
                '=',
                'products.product_id'
            )

            ->where('products.category_id', $product->category_id)
            ->where('products.product_id', '<>', $product->product_id)
            ->where('products.is_active', 1)
            ->where('products.stock_quantity', '>', 0)

            ->orderByDesc('relevance_score')
            ->limit(5)
            ->get();

        // load latest reviews with user
        $reviews = $product->reviews()->with('user')->latest()->paginate(5);

        //check exist and update product views

        ProductView::create([
            'product_id' => $product->product_id,
            'user_id' => 1
        ]);

        return view('products.show', compact('product', 'related', 'reviews'));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->product_name = $request->input('product_name', $product->product_name);
        $product->price = $request->input('price', $product->price);
        $product->description = $request->input('description', $product->description);
        $product->is_active = $request->input('is_active', $product->is_active);
        $product->save();
        return response()->json(['success' => true], 200);
    }

    public function storeReview(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:2000',
        ]);

        $review = Review::create([
            'product_id' => $product->product_id,
            'user_id' => $request->user()->user_id,
            'rating' => $data['rating'],
            'content' => $data['content'],
        ]);

        // update product rating_avg (recalculate average)
        $avg = (float) Review::where('product_id', $product->product_id)->avg('rating');
        $product->rating_avg = $avg;
        $product->save();

        return redirect()->route('products.show', $product->product_id)->with('success', 'Cảm ơn bạn đã gửi đánh giá.');
    }
}
