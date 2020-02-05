@extends('login.app')
@section('title','ลืมรหัสผ่าน')
@section('content')
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                <a href="#" onclick="location.reload();">
                    ลืมรหัสผ่าน
                </a>
            </div>
            <div class="card-body">
                <form id="forgetpass">
                  @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="username" type="text" placeholder="ชื่อผู้ใช้">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="email" id="email" type="email" placeholder="อีเมลล์">
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
        .form-group input {
            font-size: 14px;
            font-weight: 300;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(()=>{
            let formdata = $('#forgetpass');
            formdata.submit((e)=>{
                e.preventDefault();
                formdata.find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "/forget/pass",
                    data: formdata.serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            location.href='/forget/pass/view/'+data.name;
                        }else {
                            alert(data.message);
                        }
                        
                    },error: function (err) {
                        let res = err.responseJSON;
                        if(jQuery.isEmptyObject(res) == false) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key).closest('.form-group').append('<small class="text-danger">'+value+'</small>');
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush