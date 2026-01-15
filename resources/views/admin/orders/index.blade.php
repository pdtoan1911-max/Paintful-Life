@extends('admin.layout')

@section('title', 'Orders')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Order ID</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Customer</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Phone</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Total</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Payment Status</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Created</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">View</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach ($orders as $order)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 text-sm text-gray-700">#{{ $order->id }}</td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ $order->customer_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $order->phone }}</td>
              <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $order->total_amount }}</td>
              <td class="px-4 py-3">
                @php
                  $paymentStatus = $order->payment_status ?? 'pending';

                  $paymentClass = match ($paymentStatus) {
                    'done' => 'bg-green-100 text-green-700',
                    default => 'bg-gray-200 text-gray-700', // pending
                  };
                @endphp

                <span class="inline-flex items-center px-2 py-1 rounded text-sm {{ $paymentClass }}">
                  {{ ucfirst($paymentStatus) }}
                </span>
              </td>
              <td class="px-4 py-3">
                @php
                  $orderStatus = $order->order_status ?? 'new';

                  $orderClass = match ($orderStatus) {
                    'confirmed' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-200 text-gray-700', // new
                  };
                @endphp

                <span class="inline-flex items-center px-2 py-1 rounded text-sm {{ $orderClass }}">
                  {{ ucfirst($orderStatus) }}
                </span>
              </td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $order->created_at->format('Y-m-d') }}</td>
              <td class="px-4 py-3 text-sm text-center">
                <a href="{{ route('admin.orders.show', $order) }}"
                  class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800" title="Xem chi tiết">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5z" />
                  </svg>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection