@extends('layouts.app')

@section('content')
    <div style="display:flex;gap:18px">
        <aside style="width:260px">
            <div class="card" style="padding:12px">
                <h4>Danh mục</h4>
                <ul style="list-style:none;padding:0;margin:0">
                    @foreach($categories as $cat)
                        <li><a href="?category={{ $cat->category_id }}">{{ $cat->category_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div style="flex:1">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                <h3>Sản phẩm</h3>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px">
                @foreach($products as $product)
                    <div class="card" style="padding:12px;position:relative">
                        <a href="{{ route('products.show', $product->product_id) }}">
                            <img src="{{ $product->image_url ?: asset('images/products/placeholder.png') }}" alt="{{ $product->product_name }}" style="width:100%;height:160px;object-fit:cover;border-radius:8px;transition:transform .2s">
                        </a>
                        <h4 style="margin:8px 0">{{ $product->product_name }}</h4>
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div style="font-weight:700;color:var(--accent)">{{ number_format($product->price,0,',','.') }}₫</div>
                            <button class="btn-add" data-id="{{ $product->product_id }}" style="background:var(--primary);border-radius:8px;padding:8px 10px">Thêm vào giỏ</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top:18px">{{ $products->links() }}</div>
        </div>
    </div>

@endsection
