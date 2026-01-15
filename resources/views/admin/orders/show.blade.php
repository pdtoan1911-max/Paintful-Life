@extends('admin.layout')

@section('title', 'Order Detail')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Customer Info -->
    <div class="lg:col-span-1 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
      <p class="mt-4 text-sm text-gray-700">Name: {{ $order->customer_name }}</p>
      <p class="mt-2 text-sm text-gray-700">Phone: {{ $order->phone_number }}</p>
      <p class="mt-2 text-sm text-gray-700">Address: {{ $order->shipping_address ?? '-' }}</p>
      <p class="mt-2 text-sm text-gray-700">Order Status: {{ ucfirst($order->order_status ?? 'pending') }}</p>
    </div>

    <!-- Order Items -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900">Items</h3>
        <div class="mt-4 overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Product</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Price</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Qty</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Subtotal</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              @foreach ($order->orderItems as $item)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->product_name ?? ('#'.$item->product_id) }}</td>
                  <td class="px-4 py-3 text-sm text-gray-700 text-right">{{ number_format($item->unit_price ?? 0,0,',','.') }}₫</td>
                  <td class="px-4 py-3 text-sm text-gray-700 text-right">{{ $item->quantity }}</td>
                  <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ number_format( ($item->unit_price ?? 0) * ($item->quantity ?? 0),0,',','.') }}₫</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex justify-between items-center">
        <div>
          <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
          <p class="mt-2 text-sm text-gray-700">Subtotal: {{ number_format($order->subtotal,0,',','.') }}₫</p>
          <p class="mt-1 text-sm text-gray-700">Shipping: {{ number_format($order->shipping_fee,0,',','.') }}₫</p>
        </div>
        <div class="text-right">
          <p class="text-sm text-gray-700">Total:</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($order->total_amount,0,',','.') }}₫</p>
        </div>
      </div>

      <div class="flex gap-3 items-center">
        @php $status = $order->order_status ?? 'new'; @endphp

        @if($status === 'new')
          <form action="{{ route('admin.orders.confirm', $order) }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-[var(--pf-accent)] text-white rounded cursor-pointer hover:opacity-80">Confirm Order</button>
          </form>

          <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-[var(--pf-danger)] text-white rounded cursor-pointer hover:opacity-80">Cancel Order</button>
          </form>
        @else
          @php
            $label = ucfirst($status);
            $badgeClass = 'bg-gray-100 text-gray-700';
            if ($status === 'confirmed') { $badgeClass = 'bg-green-100 text-green-800'; }
            if ($status === 'cancelled' || $status === 'canceled') { $badgeClass = 'bg-red-100 text-red-800'; }
            if ($status === 'pending') { $badgeClass = 'bg-yellow-100 text-yellow-800'; }
          @endphp

          <div class="px-4 py-2 rounded-full text-sm font-medium {{ $badgeClass }}">
            Trạng thái: {{ $label }}
          </div>
        @endif
      </div>
    </div>
  </div>

@endsection
