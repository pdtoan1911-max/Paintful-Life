@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <aside class="lg:col-span-1">
            @include('partials.sidebar')
        </aside>

        <section class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Lịch sử mua hàng</h3>

                @forelse($orders as $order)
                    <div class="border rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">
                                Đơn #{{ $order->order_code }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span>
                                Tổng tiền:
                                <strong>{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                            </span>

                            <span class="px-2 py-1 rounded text-xs
                                {{ $order->order_status === 'confirmed'
                                    ? 'bg-green-100 text-green-600'
                                    : ($order->order_status === 'cancelled'
            ? 'bg-yellow-100 text-yellow-600'
            : 'bg-gray-100 text-gray-600') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">
                        Bạn chưa có đơn hàng nào.
                    </p>
                @endforelse

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
