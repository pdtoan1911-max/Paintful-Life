@extends('admin.layout')

@section('title', 'Orders')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="flex items-center justify-between gap-4 mb-4">
      <form method="GET" class="flex items-center gap-2">
        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
        <label class="text-sm text-gray-600">Từ</label>
        <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-2 py-1 border rounded">
        <label class="text-sm text-gray-600">Đến</label>
        <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-2 py-1 border rounded">

      </form>

      <form method="GET" class="ml-auto">
        @if(request('start_date'))<input type="hidden" name="start_date" value="{{ request('start_date') }}">@endif
        @if(request('end_date'))<input type="hidden" name="end_date" value="{{ request('end_date') }}">@endif
        <div class="flex items-center">
          <input type="search" name="q" placeholder="Tìm theo tên người mua" value="{{ request('q') }}" class="px-3 py-1 border w-64">
          <button type="submit" class="px-3 py-1 h-[25px] border bg-gray-100">Tìm kiếm</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Order Code</th>
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
              <td class="px-4 py-3 text-sm text-gray-700">#{{ $order->order_code }}</td>
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
    @if ($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
      <div class="mt-4 flex items-center justify-center">
        @php $orders->appends(request()->query()); $cur = $orders->currentPage(); $last = $orders->lastPage(); @endphp

        {{-- Back 1 page --}}
        <a href="{{ $orders->previousPageUrl() ?: '#' }}" class="px-3 py-1 mx-1 rounded {{ $orders->previousPageUrl() ? 'bg-white border' : 'bg-gray-100 text-gray-400' }}" aria-label="Prev">
          ‹
        </a>

        {{-- Prev page if exists --}}
        @if($cur > 1)
          <a href="{{ $orders->url($cur - 1) }}" class="px-3 py-1 mx-1 rounded bg-white border">{{ $cur - 1 }}</a>
        @endif

        {{-- Current page --}}
        <span class="px-3 py-1 mx-1 rounded bg-[var(--pf-accent)] text-white">{{ $cur }}</span>

        {{-- Next page if exists --}}
        @if($cur < $last)
          <a href="{{ $orders->url($cur + 1) }}" class="px-3 py-1 mx-1 rounded bg-white border">{{ $cur + 1 }}</a>
        @endif

        {{-- Forward 1 page --}}
        <a href="{{ $orders->nextPageUrl() ?: '#' }}" class="px-3 py-1 mx-1 rounded {{ $orders->nextPageUrl() ? 'bg-white border' : 'bg-gray-100 text-gray-400' }}" aria-label="Next">
          ›
        </a>
      </div>
    @endif
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const dateInputs = document.querySelectorAll('input[type="date"]');
      dateInputs.forEach(input => {
        input.addEventListener('change', function () {
          this.form.submit();
        });
      });
    });
  </script>
@endsection