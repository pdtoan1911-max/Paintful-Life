@extends('layouts.app')

@section('content')
    @if(session('success') || isset($success))
        <div class="card" style="padding:16px">
            <h3>Đặt hàng thành công</h3>
            <p>Đơn hàng của bạn đã được ghi nhận. Mã đơn: {{ $order->order_code ?? '' }}</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Quay về sản phẩm</a>
        </div>
    @else
    <h3>Thanh toán</h3>
    <div class="card" style="padding:12px">
        <form method="POST" action="{{ route('checkout.place') }}">
            @csrf
            <div style="display:flex;gap:12px">
                <div style="flex:1">
                    <label>Họ và tên</label>
                    <input name="customer_name" value="{{ $user->full_name ?? '' }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">

                    <label style="margin-top:8px">Số điện thoại</label>
                    <input name="phone_number" value="{{ $user->phone_number ?? '' }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">

                    <label style="margin-top:8px">Địa chỉ giao hàng</label>
                    <input name="shipping_address" value="{{ $user->address ?? '' }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">

                    <label style="margin-top:8px">Thành phố</label>
                    <input name="city" value="{{ $user->city ?? '' }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>

                <div style="width:320px">
                    <h4>Đơn hàng</h4>
                    <ul style="list-style:none;padding:0;margin:0">
                        @php $sum=0; @endphp
                        @foreach($items as $it)
                            @php $sum += ($it['product']->price * $it['quantity']); @endphp
                            <li style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #f5f5f5">{{ $it['product']->product_name }} x {{ $it['quantity'] }} <strong>{{ number_format($it['product']->price * $it['quantity'],0,',','.') }}₫</strong></li>
                        @endforeach
                    </ul>
                    <div style="margin-top:8px">Tổng: <strong>{{ number_format($sum,0,',','.') }}₫</strong></div>
                    <div style="margin-top:12px">
                        <button class="btn-primary" type="submit">Đặt hàng (COD)</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif
@endsection
