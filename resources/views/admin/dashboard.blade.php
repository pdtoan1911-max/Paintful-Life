@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Total Products</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalProducts }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Total Orders</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalOrders }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Total Revenue</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalRevenue }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <p class="text-sm text-gray-500">Orders Today</p>
      <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $ordersToday }}</p>
    </div>

  </div>
  <div class="mt-8 grid grid-cols-1 lg:grid-cols-4 gap-6">

    <div class="lg:col-span-4 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">Báo cáo doanh thu</h3>
        <form method="get" class="flex items-center space-x-2">
          <label class="text-sm text-gray-500">Xem theo</label>
          <select name="period" onchange="this.form.submit()" class="border rounded px-2 py-1">
            {{-- <option value="day" {{ (isset($period) && $period==='day') ? 'selected' : '' }}>Ngày</option> --}}
            <option value="month" {{ (isset($period) && $period==='month') ? 'selected' : '' }}>Tháng</option>
            <option value="year" {{ (isset($period) && $period==='year') ? 'selected' : '' }}>Năm</option>
          </select>
        </form>
      </div>

      <div class="mt-4 overflow-x-auto">
        <table class="w-full table-auto">
          <thead>
            <tr class="text-left text-sm text-gray-500">
              <th class="px-2 py-2">Kỳ</th>
              <th class="px-2 py-2">Doanh thu</th>
              <th class="px-2 py-2 text-right">Số lượng bán</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($revenueLabels))
              @foreach($revenueLabels as $idx => $label)
                <tr class="border-t">
                  <td class="px-2 py-2 text-sm text-gray-700">{{ $label }}</td>
                  <td class="px-2 py-2 text-sm font-medium text-gray-900">{{ number_format($revenueData[$idx] ?? 0, 0, ',', '.') }}</td>
                  <td class="px-2 py-2 text-sm text-gray-700 text-right">{{ number_format($revenueQtyData[$idx] ?? 0, 0, ',', '.') }}</td>
                </tr>
              @endforeach
            @else
              <tr><td colspan="3" class="px-2 py-4 text-sm text-gray-500">Không có dữ liệu</td></tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <h3 class="text-lg font-medium text-gray-900">Top 5 sản phẩm bán chạy</h3>
      <div class="mt-4">
        @if($topProducts->isEmpty())
          <p class="text-sm text-gray-500">Không có dữ liệu bán hàng.</p>
        @else
          <ol class="list-decimal list-inside space-y-2">
            @foreach($topProducts as $p)
              <li class="flex justify-between">
                <span class="text-sm text-gray-700">{{ $p->product_name }}</span>
                <span class="text-sm font-medium text-gray-900">{{ $p->total_qty }}</span>
              </li>
            @endforeach
          </ol>
        @endif
      </div>
    </div>
    
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <h3 class="text-lg font-medium text-gray-900">Top 5 sản phẩm xem nhiều nhất</h3>
      <div class="mt-4">
        @if($topViewedProducts->isEmpty())
          <p class="text-sm text-gray-500">Không có dữ liệu xem sản phẩm.</p>
        @else
          <ol class="list-decimal list-inside space-y-2">
            @foreach($topViewedProducts as $p)
              <li class="flex justify-between">
                <span class="text-sm text-gray-700">{{ $p->product_name }}</span>
                <span class="text-sm font-medium text-gray-900">{{ $p->total_views }}</span>
              </li>
            @endforeach
          </ol>
        @endif
      </div>
    </div>

  </div>

  <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900">Tồn kho & cảnh báo</h3>
    <p class="text-sm text-gray-500 mt-1">Sản phẩm có số lượng <= ngưỡng cảnh báo sẽ hiển thị ở đây.</p>

    <div class="mt-4 overflow-x-auto">
      @if($lowStockProducts->isEmpty())
        <p class="text-sm text-gray-500">Không có sản phẩm hết hoặc gần hết hàng.</p>
      @else
        <table class="w-full table-auto">
          <thead>
            <tr class="text-left text-sm text-gray-500">
              <th class="px-2 py-2">Sản phẩm</th>
              <th class="px-2 py-2">Số lượng</th>
              <th class="px-2 py-2">Ngưỡng cảnh báo</th>
            </tr>
          </thead>
          <tbody>
            @foreach($lowStockProducts as $prod)
              <tr class="border-t">
                <td class="px-2 py-2 text-sm text-gray-700">{{ $prod->product_name }}</td>
                <td class="px-2 py-2 text-sm font-medium text-red-600">{{ $prod->stock_quantity }}</td>
                <td class="px-2 py-2 text-sm text-gray-700">{{ $prod->low_stock_alert }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
