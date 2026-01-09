@extends('layouts.app')

@section('content')
    <div style="max-width:480px;margin:40px auto">
        <div class="card" style="padding:20px;text-align:center">
            <h3>Đăng ký</h3>
            <form method="POST" action="/register">
                @csrf
                <div style="text-align:left;margin-top:8px">
                    <label>Họ và tên</label>
                    <input name="full_name" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>
                <div style="text-align:left;margin-top:8px">
                    <label>Email</label>
                    <input name="email" type="email" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>
                <div style="text-align:left;margin-top:8px">
                    <label>Số điện thoại</label>
                    <input name="phone_number" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>
                <div style="text-align:left;margin-top:8px">
                    <label>Mật khẩu</label>
                    <input name="password" type="password" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #eee">
                </div>

                <div style="margin-top:12px">
                    <button class="btn-primary" type="submit">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
@endsection
