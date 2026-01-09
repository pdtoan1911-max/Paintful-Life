@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="relative min-h-[70vh] md:min-h-[95vh] flex items-center">
    <img
        src="{{ asset('images/banners/banner1.jpg') }}"
        alt="Sơn nội thất cao cấp Paintful Life"
        class="absolute inset-0 w-full h-full object-cover"
        loading="eager"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

    <div class="relative container mx-auto px-4">
        <div class="max-w-xl text-white">
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">
                Màu sắc chuẩn mực<br class="hidden md:block">
                cho không gian sống
            </h1>
            <p class="mt-4 text-white/90 text-sm md:text-lg">
                Sơn an toàn, bền màu – tư vấn chuyên nghiệp cho mọi công trình.
            </p>

            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('products.index') }}"
                   class="bg-[var(--pf-accent)] text-white px-6 py-3 rounded-lg font-semibold text-center">
                    Xem sản phẩm
                </a>
                <a href="#consult"
                   class="border border-white/60 text-white px-6 py-3 rounded-lg text-center">
                    Tư vấn miễn phí
                </a>
            </div>

            <!-- Trust -->
            <div class="mt-6 flex gap-4 text-xs text-white/80">
                <span>✔ VOC thấp</span>
                <span>✔ Bền màu 5 năm</span>
                <span>✔ 10.000+ KH</span>
            </div>
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $usps = [
                    ['title'=>'Chất lượng kiểm định','desc'=>'Đạt tiêu chuẩn an toàn & môi trường'],
                    ['title'=>'Bền màu vượt trội','desc'=>'Chống phai màu & bong tróc'],
                    ['title'=>'An toàn cho gia đình','desc'=>'Không độc hại, thân thiện trẻ nhỏ'],
                ];
            @endphp

            @foreach($usps as $usp)
                <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold">{{ $usp['title'] }}</h4>
                    <p class="mt-1 text-sm text-gray-600">{{ $usp['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">Danh mục phổ biến</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(['Nội thất','Ngoại thất','Trẻ em','Chống thấm'] as $cat)
                <a href="#" class="relative rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/categories/placeholder'.($loop->index + 1).'.png') }}"
                         class="w-full h-32 object-cover group-hover:scale-105 transition"
                         loading="lazy">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-semibold">{{ $cat }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-bold">Bán chạy nhất</h2>
                <p class="text-sm text-gray-500">Được khách hàng tin dùng</p>
            </div>
            <div>
                            <a href="{{ route('products.index') }}" class="text-sm text-[var(--pf-accent)]">
                Xem tất cả →
            </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                    <a href="{{ route('products.show',$product->product_id) }}">
                        <img src="{{ $product->image_url ?? asset('images/products/placeholder.png') }}"
                            class="w-full h-40 object-cover"
                            loading="lazy">
                    </a>

                    <div class="p-3">
                        <a href="{{ route('products.show',$product->product_id) }}">
                            <h3 class="text-sm font-semibold line-clamp-2 h-4">
                                {{ $product->product_name }}
                            </h3>

                            <p class="text-xs text-gray-500 mt-1 h-6">
                                {{ Str::limit($product->description, 50) }}
                            </p>
                        </a>

                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-[var(--pf-accent)] font-bold">
                                {{ number_format($product->price,0,',','.') }}₫
                            </span>

                            <button
                                class="btn-add bg-[var(--pf-accent)] text-white text-xs px-3 py-2 rounded hover:opacity-90 transition"
                                data-id="{{ $product->product_id }}">
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-2">Không gian thực tế</h2>
        <p class="text-sm text-gray-600 mb-4">
            Ứng dụng màu sơn từ khách hàng
        </p>

        <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory">
            @foreach([1,2,3,4,5,6,7,8] as $i)
                <div class="min-w-[80%] md:min-w-[30%] snap-center">
                    <img src="{{ asset("images/banners/show$i.jpg") }}"
                         class="rounded-xl w-full h-48 object-cover"
                         loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>
<section id="consult" class="py-12 bg-[var(--pf-accent)] text-white">
    <div class="container mx-auto text-center max-w-2xl">
        <h2 class="text-2xl md:text-3xl font-bold">
            Chọn màu đúng – Tiết kiệm chi phí
        </h2>
        <p class="mt-3 text-white/90">
            Đội ngũ chuyên gia Paintful Life sẵn sàng tư vấn miễn phí cho bạn.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
            <a href="#" class="bg-white text-[var(--pf-accent)] px-6 py-3 rounded-lg font-semibold">
                Nhận tư vấn
            </a>
            <a href="{{ route('products.index') }}"
               class="border border-white px-6 py-3 rounded-lg">
                Xem sản phẩm
            </a>
        </div>
    </div>
</section>

@endsection
