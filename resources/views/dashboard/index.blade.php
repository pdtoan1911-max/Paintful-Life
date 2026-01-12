@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <aside class="lg:col-span-1">
            @include('partials.sidebar')
        </aside>

        <section class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Thông tin tài khoản</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium">{{ auth()->user()->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Họ và tên</p>
                        <p class="font-medium">{{ auth()->user()->full_name ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Số điện thoại</p>
                        <p class="font-medium">{{ auth()->user()->phone_number ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Địa chỉ</p>
                        <p class="font-medium">{{ auth()->user()->address ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="#" class="inline-flex items-center px-4 py-2 rounded-lg bg-[var(--pf-accent)] text-white text-sm hover:bg-indigo-700 transition">
                        Chỉnh sửa thông tin
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection