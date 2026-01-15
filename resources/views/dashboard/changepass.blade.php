@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <aside class="lg:col-span-1">
            @include('partials.sidebar')
        </aside>

        <section class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Đổi mật khẩu</h3>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="max-w-md">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="w-full mt-1 p-2 border rounded" required />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="w-full mt-1 p-2 border rounded" required />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Nhập lại mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="w-full mt-1 p-2 border rounded" required />
                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-[var(--pf-accent)] text-white text-sm hover:bg-indigo-700 transition">Đổi mật khẩu</button>
                        <a href="{{ route('profile') }}" class="ml-2 inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm">Quay lại</a>
                    </div>
                </form>
            </div>
        </section>

    </div>
</div>
@endsection
