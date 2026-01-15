@extends('layouts.app')

@section('content')
    <h3>Giỏ hàng</h3>

    <div class="card min-h-80 p-3">
        <table class="w-full border-collapse">
            <thead>
                <tr class="text-left text-gray-500 border-b">
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
                        @php
                            $p = $it['product'];
                            $q = $it['quantity'];
                            $line = $p->price * $q;
                            $grand += $line;
                        @endphp

                        <tr data-id="{{ $p->product_id }}" class="border-b">
                            <td class="py-3">
                                <div class="flex gap-3 items-center">
                                    <img src="{{ $p->image_url ?: asset('images/products/placeholder.png') }}"
                                        class="w-16 h-16 object-cover rounded-lg">
                                    <div>{{ $p->product_name }}</div>
                                </div>
                            </td>

                            <td class="price" data-price="{{ $p->price }}">
                                {{ number_format($p->price, 0, ',', '.') }}₫
                            </td>

                            <td>
                                <input type="number" min="0" value="{{ $q }}" data-id="{{ $p->product_id }}"
                                    class="qty-input w-20 px-2 py-1 border rounded">
                            </td>

                            <td class="line-total">
                                {{ number_format($line, 0, ',', '.') }}₫
                            </td>

                            <td class="text-center">
                                <button class="btn-remove text-red-500 hover:text-red-700
                       border-none bg-white p-1 transition" data-id="{{ $p->product_id }}" aria-label="Xóa sản phẩm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                             a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                             M1 7h22m5-3h-6a2 2 0 00-2-2h-4a2 2 0
                             00-2 2H5" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer -->
        <div class="mt-8 flex flex-col sm:flex-row justify-between items-center bg-gray-50 rounded-2xl p-6 gap-4">
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-[var(--pf-accent)]">
                ← Tiếp tục mua sắm
            </a>

            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-xs text-gray-500">Tổng thanh toán</p>
                    <p id="grand-total" class="text-xl font-bold text-[var(--pf-accent)]">
                        {{ number_format($grand, 0, ',', '.') }}₫
                    </p>
                </div>

                <a href="{{ route('checkout.index') }}"
                    class="px-6 py-3 rounded-xl bg-[var(--pf-accent)] text-white font-semibold">
                    Thanh toán
                </a>
            </div>
        </div>
    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        function formatMoney(v) {
            return new Intl.NumberFormat('vi-VN').format(v) + '₫';
        }

        async function updateCart(productId, qty, row) {
            const res = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: qty
                })
            });

            const data = await res.json();
            document.getElementById('cart-badge').innerText = data.cartCount;

            if (qty <= 0) {
                row.remove();
                recalcGrandTotal();
                return;
            }

            const price = Number(row.querySelector('.price').dataset.price);
            row.querySelector('.line-total').innerText = formatMoney(price * qty);

            recalcGrandTotal();
        }

        function recalcGrandTotal() {
            let total = 0;
            document.querySelectorAll('.line-total').forEach(td => {
                total += Number(td.innerText.replace(/\D/g, ''));
            });
            document.getElementById('grand-total').innerText = formatMoney(total);
        }

        // Change quantity
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', function () {
                const row = this.closest('tr');
                updateCart(this.dataset.id, Number(this.value), row);
            });
        });

        // Remove item
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', function () {
                const row = this.closest('tr');
                const input = row.querySelector('.qty-input');
                input.value = 0;
                updateCart(this.dataset.id, 0, row);
            });
        });
    </script>
@endsection