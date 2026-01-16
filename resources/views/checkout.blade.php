@extends('layouts.app')

@section('content')
    @if(session('success') || isset($success))
        <div class="max-w-3xl mx-auto py-10">
            <div class="pf-card p-6 text-center">
                <h3 class="text-2xl font-semibold">Đặt hàng thành công</h3>
                <p class="mt-3 text-gray-700">Đơn hàng của bạn đã được ghi nhận.</p>
                @if(isset($order->order_code))
                    <div class="mt-2 text-sm text-gray-500">Mã đơn: <strong>{{ $order->order_code }}</strong></div>
                @endif
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="pf-btn">Quay về sản phẩm</a>
                </div>
            </div>
        </div>
    @else
    <div class="max-w-7xl mx-auto py-10">
        <form method="POST" action="{{ route('checkout.place') }}">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left: Recipient info -->
                <div class="lg:col-span-5">
                    <div class="pf-card p-6">
                        <h2 class="text-lg font-semibold mb-2">Thông tin nhận hàng</h2>
                        <div id="recipient-warning" class="hidden text-sm text-red-600 mt-1 mb-3">Bạn cần điền các trường bắt buộc để chúng tôi có thể phục vụ tốt nhất</div>

                        <div class="grid grid-cols-2 md:grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                                <input name="customer_name" value="{{ old('customer_name', $user->full_name ?? '') }}" required class="mt-1 block w-full rounded-md border border-gray-200 py-2" />
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
                                <input name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}" required class="mt-1 block w-full rounded-md border border-gray-200 py-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm text-gray-700">Địa chỉ giao hàng <span class="text-red-500">*</span></label>
                            <input name="shipping_address" value="{{ old('shipping_address', $user->address ?? '') }}" required class="mt-1 block w-full rounded-md border border-gray-200 py-2" />
                        </div>

                        <div class="grid grid-cols-3 md:grid-cols-1 gap-4 mt-4">
                            <div>
                                <label class="block text-sm text-gray-700">Thành phố <span class="text-red-500">*</span></label>
                                <input name="city" value="{{ old('city', $user->city ?? '') }}" required class="mt-1 block w-full rounded-md border border-gray-200 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">Phường/Xã <span class="text-red-500">*</span></label>
                                <input name="district" value="{{ old('district', $user->district ?? '') }}" required class="mt-1 block w-full rounded-md border border-gray-200 py-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm text-gray-700">Ghi chú (tùy chọn)</label>
                            <textarea name="note" rows="3" class="mt-1 block resize-y w-full rounded-md border border-gray-200 py-2">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Middle: Shipping & Payment -->
                <div class="lg:col-span-3">

                    <div class="pf-card p-6">
                        <h3 class="text-lg font-semibold mb-3">Phương thức thanh toán</h3>

                        <div class="space-y-3">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="payment_method" value="cod" checked class="mt-1" />
                                <div>
                                    <div class="font-medium">Thanh toán khi giao hàng (COD)</div>
                                    <div class="text-sm text-gray-500">Thanh toán tiền mặt cho nhân viên giao hàng.</div>
                                </div>
                            </label>

                            <label class="flex items-start gap-3">
                                <input type="radio" name="payment_method" value="bank" class="mt-1" />
                                <div>
                                    <div class="font-medium">Chuyển khoản ngân hàng</div>
                                    <div class="text-sm text-gray-500">Thanh toán trước qua Internet Banking.</div>
                                </div>
                            </label>

                            <label class="flex items-start gap-3">
                                <input type="radio" name="payment_method" value="online" class="mt-1" />
                                <div>
                                    <div class="font-medium">Thanh toán trực tuyến (thẻ)</div>
                                    <div class="text-sm text-gray-500">Visa, Mastercard, VNPay, v.v.</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right: Order summary -->
                <aside class="lg:col-span-4">
                    <div class="pf-card p-6 sticky top-24">
                        <h3 class="text-lg font-semibold">Đơn hàng ({{ count($items) }} sản phẩm)</h3>

                        <div class="mt-4 space-y-3">
                            @php $sum = 0; @endphp
                            @foreach($items as $it)
                                @php $line = $it['product']->price * $it['quantity']; $sum += $line; @endphp
                                <div class="flex items-start gap-3">
                                    <img src="{{ $it['product']->image_url ?: asset('images/products/placeholder.png') }}" class="w-12 h-12 object-cover rounded" alt="{{ $it['product']->product_name }}" />
                                    <div class="flex-1 text-sm">
                                        <div class="font-medium">{{ $it['product']->product_name }}</div>
                                        <div class="text-gray-500 text-xs">x {{ $it['quantity'] }}</div>
                                    </div>
                                    <div class="text-sm font-semibold text-[var(--pf-accent)]">{{ number_format($line,0,',','.') }}₫</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm text-gray-700">Mã giảm giá</label>
                            <div class="flex items-center gap-2 mt-2">
                                <input name="coupon" class="flex-1 rounded-md border border-gray-200 px-3 py-2 text-sm" placeholder="Nhập mã" />
                                <button type="button" class="pf-btn">Áp dụng</button>
                            </div>
                        </div>

                        <div class="mt-4 border-t border-gray-100 pt-4 text-sm">
                            <div class="flex justify-between text-gray-600">Tạm tính <span>{{ number_format($sum,0,',','.') }}₫</span></div>
                            <div class="flex justify-between text-gray-600 mt-2">Phí vận chuyển <span>—</span></div>
                            <div class="flex justify-between font-bold text-lg mt-3">Tổng cộng <span class="text-[var(--pf-accent)]">{{ number_format($sum,0,',','.') }}₫</span></div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="w-full pf-btn py-3">Đặt hàng</button>
                        </div>
                        <a href="{{ route('cart.index') }}" class="block text-center text-sm text-gray-500 mt-3">‹ Quay về giỏ hàng</a>
                    </div>
                </aside>
            </div>
        </form>
    </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const form = document.querySelector('form[action="{{ route('checkout.place') }}"]');
            if(!form) return;

            const requiredSelectors = [
                'input[name="customer_name"]',
                'input[name="phone_number"]',
                'input[name="city"]',
                'input[name="district"]'
            ];

            const warning = document.getElementById('recipient-warning');

            function markError(el){
                el.classList.add('border-red-500','ring-1','ring-red-200');
                el.setAttribute('aria-invalid', 'true');
            }
            function clearError(el){
                el.classList.remove('border-red-500','ring-1','ring-red-200');
                el.removeAttribute('aria-invalid');
            }

            // Clear on input
            requiredSelectors.forEach(sel => {
                const el = document.querySelector(sel);
                if(!el) return;
                el.addEventListener('input', function(){
                    if(this.value.trim() !== '') clearError(this);
                });
            });

            form.addEventListener('submit', function(e){
                let missing = [];
                requiredSelectors.forEach(sel => {
                    const el = document.querySelector(sel);
                    if(!el) return;
                    if(el.value.trim() === ''){
                        missing.push(el);
                        markError(el);
                    } else {
                        clearError(el);
                    }
                });

                if(missing.length){
                    e.preventDefault();
                    warning.classList.remove('hidden');
                    warning.scrollIntoView({behavior:'smooth',block:'center'});
                    missing[0].focus();
                    return false;
                }

                return true; // allow submit
            });
        });
    </script>
@endsection
