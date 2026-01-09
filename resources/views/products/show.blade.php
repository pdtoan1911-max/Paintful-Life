@extends('layouts.app')

@section('content')
    <div style="display:flex;gap:20px;align-items:flex-start">
        <div style="flex:1">
            <div class="card" style="padding:12px">
                <img src="{{ $product->image_url ?: asset('images/products/placeholder.png') }}" alt="{{ $product->product_name }}" style="width:100%;height:420px;object-fit:cover;border-radius:8px">
            </div>
        </div>

        <div style="width:420px">
            <div class="card" style="padding:18px">
                <h2 style="margin-top:0">{{ $product->product_name }}</h2>
                <div style="font-size:20px;color:var(--accent);font-weight:700">{{ number_format($product->price,0,',','.') }}₫</div>
                <p style="color:#666">{{ $product->description }}</p>

                <div style="margin-top:12px;display:flex;gap:8px;align-items:center">
                    <input id="qty" type="number" value="1" min="1" style="width:80px;padding:8px;border-radius:8px;border:1px solid #eee">
                    <button class="btn-add btn-primary" data-id="{{ $product->product_id }}">Thêm vào giỏ</button>
                </div>
            </div>

            @if($related->count())
            <div style="margin-top:12px">
                <h4>Sản phẩm liên quan</h4>
                <div style="display:flex;gap:8px;overflow:auto">
                    @foreach($related as $r)
                        <a href="{{ route('products.show',$r->product_id) }}" style="min-width:120px">
                            <img src="{{ $r->image_url ?: asset('images/products/placeholder.png') }}" alt="{{ $r->product_name }}" style="width:100%;height:80px;object-fit:cover;border-radius:6px">
                            <div style="font-size:13px">{{ $r->product_name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
