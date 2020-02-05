@extends('admin.layout.app')
@section('title','ข้อมูลของฉัน')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12 col-xl-12">
                <div class="card">
                    <h5 class="card-header">ข้อมูลของฉัน</h5>
                    <div class="card-body">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                            <form id="Updates">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">
                                <div class="form-group mb-3">
                                    <div class="profile text-center">
                                        <input type="file" name="image" id="image" hidden="hidden">
                                        <img src="/uploads/{{Auth::user()->image}}" class="rounded-circle shadow" id="myProfile" alt="Profile">
                                        <br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">ชื่อ-สกุล</label>
                                    <input id="name" class="form-control" type="text" name="name" value="{{Auth::user()->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="">อีเมลล์</label>
                                    <input id="email" class="form-control" type="text" name="email" value="{{Auth::user()->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="">ชื่อผู้ใช้งาน</label>
                                    <input id="username" class="form-control" type="text" name="username" value="{{Auth::user()->username}}">
                                </div>
                                <div class="form-group">
                                    <label for="">รหัสผ่าน</label>
                                    <input id="password" class="form-control" type="password" name="password" placeholder="ยืนยันกรบันทึก">
                                </div>
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-light">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>

        
        let myProfile = document.getElementById('image');
        let fileURL = document.getElementById('file_url');
        let btnProfile = document.getElementById('myProfile');
        
        // btnProfile.addEventListener('click',()=>{
        //     myProfile.click();
        // });

        // myProfile.addEventListener('change',()=>{
        //     if(myProfile.value) {
        //         fileURL.innerHTML = fileURL.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        //     }else {
        //         fileURL.innerHTML = '';
        //     }
        // });

        $(document).ready(function(){
            let Updates = $('#Updates');

            Updates.submit((e)=>{
                e.preventDefault();
                const id = "{{Auth::user()->id}}";
                Updates.find('small').remove();

                $.ajax({
                    type: "POST",
                    url: "/admin/profile",
                    data: Updates.serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            alert(data.message);
                            location.href="/";
                        }else {
                            alert(data.message);
                        }
                    },error: function (xhr) {
                        var res = xhr.responseJSON;
                        if (jQuery.isEmptyObject(res) ==false ) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key)
                                    .closest('.form-group')
                                    .append('<small id="helpId" class="text-danger">'+value+'</small>');
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
@push('style')
    <style>
        #file_url {
            padding: 30px 0px !important;
        }
        .search-control {
            display: none;
        }
        .form-group label, .form-group input {
            font-size: 14px;
            font-weight: 300;
        }

        .form-group button {
            font-size: 14px;
            font-weight: 500;
        }
        .profile img {
            border: 8px solid rgba(230, 230, 242, .5);
            width: 200px;
            height: 200px;
        }
    </style>
@endpush