@extends('admin.layout')

@section('title', 'User Detail')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex justify-between items-start">
      <div>
        <h2 class="text-lg font-medium">{{ $user->full_name }}</h2>
        <p class="text-sm text-gray-600">{{ $user->email }}</p>
        <p class="text-sm text-gray-600">{{ $user->phone_number ?? '-' }}</p>
        <p class="text-sm text-gray-600">{{ $user->is_active ? 'Active' : 'Inactive' }}</p>
      </div>
      <div>
        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
          @csrf
          <button type="submit"
            class="inline-flex items-center gap-2 px-3 py-1 rounded text-sm font-medium
             {{ $user->is_active ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-green-600 text-white hover:bg-green-700' }}"
            title="{{ $user->is_active ? 'Lock user' : 'Unlock user' }}">
            {{-- Text --}}
            <span>
              {{ $user->is_active ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}
            </span>

            {{-- Icon --}}
            @if($user->is_active)
              {{-- Lock icon --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 11c1.657 0 3 .895 3 2v3a3 3 0 11-6 0v-3c0-1.105 1.343-2 3-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0v4" />
              </svg>
            @else
              {{-- Unlock icon --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 11c1.657 0 3 .895 3 2v3a3 3 0 11-6 0v-3c0-1.105 1.343-2 3-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 11V7a4 4 0 00-7.75-1" />
              </svg>
            @endif
          </button>
        </form>
      </div>
    </div>

    <hr class="my-4">

    <h3 class="text-md font-medium mb-2">Orders</h3>
    <div class="space-y-3">
      @foreach($user->orders()->latest()->take(20)->get() as $order)
        <div class="border rounded p-3 flex justify-between items-center">
          <div>
            <div class="text-sm font-medium">Order #{{ $order->order_code ?? $order->order_id }}</div>
            <div class="text-xs text-gray-600">Total: {{ number_format($order->total_amount, 0, ',', '.') }}₫</div>
            <div class="text-xs text-gray-600">Status: {{ $order->order_status }}</div>
          </div>
          <div>
            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">View</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>

@endsection