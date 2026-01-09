@extends('layouts.app')

@section('content')
    <div style="max-width:420px;margin:40px auto">
        <div class="card" style="padding:20px;text-align:center">
            <h3>Đăng nhập</h3>
            <form method="POST" action="/login">
                @csrf
                <div style="text-align:left;margin-top:8px">
                    <label>Email hoặc SĐT</label>
                    <input name="login" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>
                <div style="text-align:left;margin-top:8px">
                    <label>Mật khẩu</label>
                    <input name="password" type="password" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>
                <div style="margin-top:12px">
                    <button class="btn-primary" type="submit">Đăng nhập</button>
                </div>
            </form>
            <div style="margin-top:12px">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></div>
        </div>
    </div>
@endsection
