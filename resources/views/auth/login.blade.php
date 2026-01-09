@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto py-12 px-4">
        <div class="pf-card p-8">
            <h1 class="text-2xl font-semibold text-center">ĐĂNG NHẬP TÀI KHOẢN</h1>
            <p class="text-center text-sm text-gray-600 mt-2">Bạn chưa có tài khoản ? <a href="{{ route('register') }}" class="text-[var(--pf-accent)] font-medium">Đăng ký tại đây</a></p>

            <form method="POST" action="/login" class="mt-6">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email hoặc SĐT <span class="text-red-500">*</span></label>
                    <input name="login" required placeholder="Email hoặc số điện thoại" class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
                    <input name="password" type="password" required placeholder="Mật khẩu" class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                </div>

                <div class="flex justify-between items-center text-sm mt-2">
                    <div></div>
                    <a href="#" class="text-[var(--pf-accent)]">Quên mật khẩu? Nhấn vào đây</a>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-[var(--pf-accent)] text-white font-semibold py-3 rounded-full shadow-md hover:brightness-95 transition">Đăng nhập</button>
                </div>
            </form>

            <div class="mt-4 text-center text-sm text-gray-600">Hoặc <a href="{{ route('register') }}" class="text-[var(--pf-accent)] font-medium">Đăng ký</a> nếu bạn chưa có tài khoản</div>
        </div>
    </div>
@endsection
