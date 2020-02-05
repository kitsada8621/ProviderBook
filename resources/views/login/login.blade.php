@extends('login.app')
@section('title','เข้าสู่ระบบ')
@section('content')
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                <a href="#" onclick="location.reload();">
                    ระบบยืม-คืนหนังสือ
                </a>
                <span class="splash-description">เว็บภายในสาขา เฉพาะสมาชิกเท่านั้น</span>
            </div>
            <div class="card-body">
                <form action="{{route('login-submit')}}" method="POST">
                  @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="username" type="text" placeholder="ชื่อผู้ใช้หรือรหัสนักศึกษา" autocomplete="off">
                        @error('username')
                            <strong class="small text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="รหัสผ่าน">
                        @error('username')
                            <strong class="small text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">จดจำสมาชิก</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">เข้าสู่ระบบ</button>
                </form>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="/forget/pass">ลืมรหัสผ่าน</a>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .card-header a {
            font-family: 'Chonburi', cursive;
            font-size: 25px;
            /* color: #5969ff; */
        }
        .card-header a:hover {
            color: #71748d;
        }
        .custom-control-label {
            font-size: 13px;
        }
        .card-footer-item a {
            font-size: 14px;
            font-weight: 500;
        }
        .card-footer-item a:hover {
            color: #5969ff;
        }
        .card-body button {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .form-group input {
            font-size: 14px;
            font-weight: 300;
            padding-left: 20px;
        }
    </style>
@endpush