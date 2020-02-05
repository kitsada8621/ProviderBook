@extends('login.app')
@section('title','ลืมรหัสผ่าน')
@section('content')
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                <a href="#" onclick="location.reload();">
                    ตั้งค่ารหัสผ่านใหม่
                </a>
            </div>
            <div class="card-body">
                <form id="formPass">
                    @csrf
                    <input type="text" class="form-control" id="id" hidden="hidden" value="{{$id}}">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="pass" id="pass" type="password" placeholder="รหัสผ่าน">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="passconfirm" id="passconfirm" type="password" placeholder="ยืนยัน รหัสผ่าน">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">ยืนยัน</button>
                    <button type="button" class="btn btn-light btn-lg btn-block" onclick="location='{{route('login')}}';">ยกเลิก</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .form-group {
            font-size: 14px;
            font-weight: 300;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(()=>{
            let formpass = $('#formPass');
            formpass.submit((e)=>{
                e.preventDefault();
                formpass.find('small').remove();
                const id = $('#id').val();

                $.ajax({
                    type: "put",
                    url: "/forget/pass/confirm/"+id,
                    data: formpass.serialize(),
                    dataType: "json",
                    success: function (data) {
                        location.href="{{route('login')}}";
                    },error: function (err) {
                        const res = err.responseJSON;
                        if(jQuery.isEmptyObject(res) == false) {
                            jQuery.each(res.errors,function(key,value) {
                                jQuery('#'+key).closest('.form-group').append('<small>'+value+'</small>');
                            });
                        }
                    }
                });

            });
        });
    </script>
@endpush