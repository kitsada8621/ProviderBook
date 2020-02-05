@extends('student.layouts.app')
@section('title','จัดการรหัสผ่าน')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">จัดการรหัสผ่าน</h2>
                    <p class="pageheader-text"></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <h5 class="card-header">แก้ไขรหัสผ่าน</h5>
                    <div class="card-body">
                        <form id="FormPass">
                            @csrf
                            <div class="form-group row d-flex align-items-center">
                                <label for="password" class="col-12 col-sm-3 col-form-label text-sm-right">รหัสผ่านเดิม</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="password" class="form-control" name="pass_old" id="pass_old">
                                </div>
                                <small class="err_oldPass text-danger"></small>
                            </div>
                            <div class="form-group row d-flex align-items-center">
                                <label for="password" class="col-12 col-sm-3 col-form-label text-sm-right">รหัสผ่านใหม่</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="password" class="form-control" name="pass_new" id="pass_new">
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center">
                                <label for="password" class="col-12 col-sm-3 col-form-label text-sm-right">ยืนยัน รหัสผ่านใหม่</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="password" class="form-control" name="pass_same" id="pass_same">
                                </div>
                            </div>
                            <div class="form-group row text-right d-flex align-items-center">
                                <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                    <button type="button" class="btn btn-space btn-light" onclick="location.href='/user/student/home';">ยกเลิก</button>
                                    <button type="submit" class="btn btn-space btn-primary">ยืนยัน</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(()=>{

            const PassForm = $('#FormPass');

            PassForm.submit((e)=>{
                e.preventDefault();
                PassForm.find('small').remove();
                const id = "{{Auth::guard('students')->user()->std_id}}";

                $.ajax({
                    type: "PUT",
                    url: "/user/setting/password/"+id,
                    data: PassForm.serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        if(data.success == true) {
                            location.href="{{route('student.logout')}}";
                            alert(data.message);
                        }else {
                            alert(data.message);
                        }
                        PassForm[0].reset();
                    },error: function (err) {
                        let res = err.responseJSON;
                        if(jQuery.isEmptyObject(res) == false) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key).closest('.form-group').append('<small class="text-danger">'+value+'</small>')
                            });
                        }
                    }
                });
            });

        });
    </script>
@endpush