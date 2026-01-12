@extends('admin.layout')

@section('title', 'Order Detail')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Customer Info -->
    <div class="lg:col-span-1 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
      <p class="mt-4 text-sm text-gray-700">Name: {{ $order->customer_name }}</p>
      <p class="mt-2 text-sm text-gray-700">Phone: {{ $order->phone }}</p>
      <p class="mt-2 text-sm text-gray-700">Email: {{ $order->email ?? '-' }}</p>
      <p class="mt-2 text-sm text-gray-700">Address: {{ $order->address ?? '-' }}</p>
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
              @foreach ($order->items as $item)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product_name }}</td>
                  <td class="px-4 py-3 text-sm text-gray-700 text-right">{{ $item->price }}</td>
                  <td class="px-4 py-3 text-sm text-gray-700 text-right">{{ $item->quantity }}</td>
                  <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $item->price * $item->quantity }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
        <div class="mt-4 text-right">
          <p class="text-sm text-gray-700">Total:</p>
          <p class="text-2xl font-semibold text-gray-900">{{ $order->total_amount }}</p>
        </div>
      </div>
    </div>
  </div>

@endsection
