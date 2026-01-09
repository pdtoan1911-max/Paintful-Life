@extends('layouts.app')

@section('content')
    <div style="display:flex;gap:20px">
        <aside style="width:240px">
            <div class="card" style="padding:12px;text-align:center">
                <div style="width:88px;height:88px;border-radius:999px;background:#eee;margin:0 auto"></div>
                <h4 style="margin-top:8px">{{ auth()->user()->full_name ?? auth()->user()->email }}</h4>
                <nav style="margin-top:8px;text-align:left">
                    <a href="#">Thông tin tài khoản</a><br>
                    <a href="#">Lịch sử mua hàng</a>
                </nav>
            </div>
        </aside>

        <div style="flex:1">
            <div class="card" style="padding:12px">
                <h3>Thông tin tài khoản</h3>
                <p>Email: {{ auth()->user()->email }}</p>
                <p>Họ và tên: {{ auth()->user()->full_name }}</p>
                <p>SĐT: {{ auth()->user()->phone_number }}</p>
            </div>
        </div>
    </div>
@endsection
