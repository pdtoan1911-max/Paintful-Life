@extends('layouts.app')

@section('content')
    <h3>Giỏ hàng</h3>
    <div class="card min-h-80" style="padding:12px">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="text-align:left;color:#666;border-bottom:1px solid #eee">
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $grand = 0; @endphp
                @foreach($items as $it)
                    @php $p = $it['product']; $q = $it['quantity']; $line = $p->price * $q; $grand += $line; @endphp
                    <tr style="border-bottom:1px solid #f0f0f0">
                        <td style="padding:12px;vertical-align:middle;">
                            <div style="display:flex;gap:12px;align-items:center">
                                <img src="{{ $p->image_url ?: asset('images/products/placeholder.png') }}" style="width:64px;height:64px;object-fit:cover;border-radius:8px">
                                <div>
                                    <div>{{ $p->product_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ number_format($p->price,0,',','.') }}₫</td>
                        <td>
                            <input class="qty-input" data-id="{{ $p->product_id }}" type="number" value="{{ $q }}" min="0" style="width:80px;padding:6px;border-radius:6px;border:1px solid #eee">
                        </td>
                        <td>{{ number_format($line,0,',','.') }}₫</td>
                        <td class="text-center">
                            <button
                                class="btn-remove text-red-500 cursor-pointer hover:text-red-700 font-bold text-lg leading-none border-none bg-white transition"
                                data-id="{{ $p->product_id }}"
                                aria-label="Xóa sản phẩm">
                                x
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between
                    bg-gray-50 rounded-2xl p-4 sm:p-6">

            <!-- Continue shopping -->
            <a href="{{ route('products.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium
                    text-[var(--pf-accent)] hover:text-pf-accent transition">
                <span class="text-lg">←</span>
                Tiếp tục mua sắm
            </a>

            <!-- Total + Checkout -->
            <div class="flex items-center justify-between sm:justify-end gap-4">
                <div class="text-right">
                    <p class="text-xs text-gray-500 mt-0">Tổng thanh toán</p>
                    <p class="text-xl font-bold text-[var(--pf-accent)] mt-0">
                        {{ number_format($grand,0,',','.') }}₫
                    </p>
                </div>

                <a href="{{ route('checkout.index') }}"
                class="px-6 py-3 rounded-xl bg-[var(--pf-accent)] text-white
                        font-semibold shadow-md hover:shadow-lg
                        hover:opacity-95 transition">
                    Thanh toán
                </a>
            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll('.qty-input').forEach(function(el){
            el.addEventListener('change', function(){
                const id = this.dataset.id;
                const qty = Number(this.value);
                fetch('/cart/update', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')},body:JSON.stringify({product_id:id,quantity:qty})})
                .then(r=>r.json()).then(j=>{ document.getElementById('cart-badge').innerText = j.cartCount; location.reload(); });
            });
        });

        
        document.querySelectorAll('.btn-remove').forEach(function(el){
            el.addEventListener('click', function(){
                const id = this.dataset.id;
                const qty = 0;
                fetch('/cart/update', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')},body:JSON.stringify({product_id:id,quantity:qty})})
                .then(r=>r.json()).then(j=>{ document.getElementById('cart-badge').innerText = j.cartCount; location.reload(); });
            });
        });
    </script>

@endsection
