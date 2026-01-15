@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto py-12 px-4">
        <div class="pf-card p-8">
            <h1 class="text-2xl font-semibold text-center">ĐĂNG KÝ TÀI KHOẢN</h1>
            <p class="text-center text-sm text-gray-600 mt-2">Bạn đã có tài khoản ? <a href="{{ route('login') }}"
                    class="text-[var(--pf-accent)] font-medium">Đăng nhập tại đây</a></p>

            <form method="POST" action="/register" class="mt-6">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Họ và tên <span
                                class="text-red-500">*</span></label>
                        <input name="full_name" required placeholder="Họ và tên" value="{{ old('full_name') }}"
                            class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email <span
                                class="text-red-500">*</span></label>
                        <input name="email" type="email" required placeholder="Email" value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Số điện thoại <span
                                class="text-red-500">*</span></label>
                        <input name="phone_number" required placeholder="Số điện thoại" value="{{ old('phone_number') }}"
                            class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mật khẩu <span
                                class="text-red-500">*</span></label>
                        <input name="password" type="password" required placeholder="Mật khẩu"
                            class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Xác nhận mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input name="password_confirmation" type="password" required placeholder="Nhập lại mật khẩu" class="mt-1 block w-full rounded-md border border-gray-200 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]" />
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="w-full bg-[var(--pf-accent)] text-white font-semibold py-3 rounded-full shadow-md hover:brightness-95 transition">Đăng
                            ký</button>
                    </div>
                </div>
            </form>

            <div class="mt-4 text-center text-sm text-gray-600">Bằng cách đăng ký bạn đồng ý với <a href="#"
                    class="text-[var(--pf-accent)]">Điều khoản</a> và <a href="#" class="text-[var(--pf-accent)]">Chính sách
                    bảo mật</a>.</div>
        </div>
    </div>
@endsection