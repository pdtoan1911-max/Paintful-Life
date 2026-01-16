<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductView;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with simple stats.
     */
    public function index(Request $request)
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('order_status', 'confirmed')
    ->sum('total_amount');
        $ordersToday = Order::whereDate('created_at', now()->toDateString())->count();

        // Revenue report: group by day / month / year
        $period = $request->get('period', 'month'); // day, month, year
        $revenueLabels = [];
        $revenueData = [];
        $revenueQtyData = [];

        if ($period === 'day') {
            $days = 30;
            $start = now()->subDays($days - 1)->startOfDay();
            $rows = Order::select(DB::raw('date(created_at) as period'), DB::raw('SUM(total_amount) as revenue'))
                ->where('created_at', '>=', $start)
                ->where('orders.order_status', 'confirmed')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->keyBy('period');

            $qtyRows = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->select(DB::raw('date(orders.created_at) as period'), DB::raw('SUM(order_items.quantity) as qty'))
                ->where('orders.created_at', '>=', $start)
                ->where('orders.order_status', 'confirmed')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->keyBy('period');

            for ($i = 0; $i < $days; $i++) {
                $date = $start->copy()->addDays($i)->toDateString();
                $revenueLabels[] = $date;
                $revenueData[] = isset($rows[$date]) ? (float) $rows[$date]->revenue : 0;
                $revenueQtyData[] = isset($qtyRows[$date]) ? (int) $qtyRows[$date]->qty : 0;
            }
        } elseif ($period === 'year') {
            $years = 3;
            $startYear = now()->subYears($years - 1)->year;
            $rows = Order::select(DB::raw("strftime('%Y', created_at) as period"), DB::raw('SUM(total_amount) as revenue'))
                ->whereYear('created_at', '>=', $startYear)
                ->where('orders.order_status', 'confirmed')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->keyBy('period');

            $qtyRows = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->select(DB::raw("strftime('%Y', orders.created_at) as period"), DB::raw('SUM(order_items.quantity) as qty'))
                ->whereYear('orders.created_at', '>=', $startYear)
                ->where('orders.order_status', 'confirmed')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->keyBy('period');

            for ($y = $startYear; $y <= now()->year; $y++) {
                $revenueLabels[] = (string) $y;
                $revenueData[] = isset($rows[$y]) ? (float) $rows[$y]->revenue : 0;
                $revenueQtyData[] = isset($qtyRows[$y]) ? (int) $qtyRows[$y]->qty : 0;
            }
        } else {
            // default: month (last 12 months)
            $months = 6;
            $start = now()->subMonths($months - 1)->startOfMonth();
            $rows = Order::select(DB::raw("strftime('%Y-%m', created_at) as period"), DB::raw('SUM(total_amount) as revenue'))
                ->where('created_at', '>=', $start)
                ->where('orders.order_status', 'confirmed')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->keyBy('period');

            $qtyRows = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->select(DB::raw("strftime('%Y-%m', orders.created_at) as period"), DB::raw('SUM(order_items.quantity) as qty'))
                ->where('orders.created_at', '>=', $start)
                ->where('orders.order_status', 'confirmed')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->keyBy('period');

            for ($i = 0; $i < $months; $i++) {
                $date = $start->copy()->addMonths($i)->format('Y-m');
                $revenueLabels[] = $date;
                $revenueData[] = isset($rows[$date]) ? (float) $rows[$date]->revenue : 0;
                $revenueQtyData[] = isset($qtyRows[$date]) ? (int) $qtyRows[$date]->qty : 0;
            }
        }

        // Top 5 best-selling products by quantity
        $topProducts = OrderItem::join('products', 'order_items.product_id', '=', 'products.product_id')
            ->select('products.product_id', 'products.product_name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Top 5 most viewed products
        $topViewedProducts = ProductView::join('products', 'product_views.product_id', '=', 'products.product_id')
            ->select('products.product_id', 'products.product_name', DB::raw('COUNT(product_views.view_id) as total_views'))
            ->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        // Low stock alerts
        $lowStockProducts = Product::whereRaw('stock_quantity <= low_stock_alert')->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue', 'ordersToday',
            'revenueLabels', 'revenueData', 'revenueQtyData', 'period', 'topProducts', 'lowStockProducts', 'topViewedProducts'
        ));
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        // delete cart items, orders, etc. if needed
        $cart = $user->cartItems();
        $cart->delete();
        $orders = $user->orders();
        foreach ($orders as $order) {
            $order->orderItems()->delete();
            $order->delete();
        }
        $reviews = $user->reviews();
        $reviews->delete();
        $productViews = $user->productViews();
        $productViews->delete();
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function indexOrder(Request $request)
    {
        $query = Order::query();

        if ($q = $request->query('q')) {
            $query->where('customer_name', 'like', "%{$q}%");
        }

        if ($start = $request->query('start_date')) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end = $request->query('end_date')) {
            $query->whereDate('created_at', '<=', $end);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }
}
