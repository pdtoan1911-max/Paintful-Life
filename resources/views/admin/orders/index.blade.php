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
                <span class="inline-flex items-center px-2 py-1 rounded text-sm bg-gray-200 text-gray-700">{{ $order->status ?? 'pending' }}</span>
              </td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $order->created_at->format('Y-m-d') }}</td>
              <td class="px-4 py-3 text-sm"><a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">View</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
