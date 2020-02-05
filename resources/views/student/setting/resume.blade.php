@extends('student.layouts.app')
@section('title','ประวัติส่วนตัว (นักศึกษา)')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <h5 class="card-header">ข้อมูลส่วนตัว</h5>
                    <div class="card-body p-0">
                    <form id="formResume">
                        @csrf
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="imageProfile text-center">
                                    <img class="rounded-circle shadow" src="/uploads/{{Auth::guard('students')->user()->image}}" alt="Profile">
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">รหัสนักศึกษา</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" id="std_id" name="std_id" class="form-control" value="{{Auth::guard('students')->user()->std_id}}" readonly>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">ชื่อนักศึกษา</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" id="std_name" name="std_name" class="form-control" value="{{Auth::guard('students')->user()->std_name}}">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">ชื่อนักศึกษา</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="text" id="major" name="major" class="form-control" value="{{Auth::guard('students')->user()->major}}">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">อีเมลล์</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="email" name="email" id="email" class="form-control" value="{{Auth::guard('students')->user()->email}}">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right">เบอร์โทร</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="tel" id="tel" name="tel" class="form-control" value="{{Auth::guard('students')->user()->tel}}">
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="list-group-item">
                                <div class="form-group row text-right">
                                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                        <button type="button" class="btn btn-space btn-light">ยกเลิก</button>
                                        <button type="submit" class="btn btn-space btn-primary">อัพเดต</button>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>                                         
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
@push('style')
    <style>
        .imageProfile img{
            width: 200px;
            height: 200px;
            border: 6px solid #fff;
        }
        .form-file {
            margin-top: 28px;
        }
        .form-file a {
            font-size: 13px; font-weight: 300;
        }.form-file a i {
            font-size: 12px;
            margin-right: 5px;
        }#text-file {
            font-size: 13px; font-weight: 300;
            margin-left: 5px;
            color: gray;
        }
        .profiler img{
            width: 200px;
            height: 200px;
            border-radius: 10rem;
        }
        .profiler {
            padding: 30px 0px;
            text-align: center;
        } 
        .form-group label {
            font-size: 14px;
            font-weight: 400;
        }
        .form-group .form-control {
            font-size: 14px;
            font-weight: 300;
        }
        .form-control option {
            font-size: 14px;
            font-weight: 300;
        } .form-group button {
            font-size: 14px;
            font-weight: 300;
        }
        .form-group button i {
            font-size: 12px;
        }
        .list-group .list-group-item .form-group {
            padding: 0px;
        }
        .list-group-item:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(()=>{

            // const inputfile = document.getElementById('custom-file');
            // const btnfile = document.getElementById('btn-file');
            // const textfile = document.getElementById('text-file');
            // const imgUploads = document.getElementById('ti-profile');

            // btnfile.addEventListener('click',()=>{
            //     inputfile.click();
            // });

            // imgUploads.addEventListener('click',()=>{
            //     inputfile.click();
            // });

            // document.getElementById('ti-profile1').addEventListener('click',()=>{
            //     alert('yes');
            // });

            // inputfile.addEventListener('change',()=>{

            //     if(inputfile.value) {
            //         textfile.innerHTML = inputfile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            //     }else {
            //         textfile.innerHTML = "Yes";
            //     }
            // });

            // const formResume = $('#formResume');
            // formResume.submit((e)=>{
            //     e.preventDefault();
            //     formResume.find('small').remove();

            //     $.ajax({
            //         type: "put",
            //         url: "{{route('users.resume.put')}}",
            //         data: formResume.serialize(),
            //         dataType: "json",
            //         success: function (data) {
            //             alert(data.message);
            //             location.reload();
            //         },error: function (err) {
            //             let res = err.responseJSON;
            //             if(jQuery.isEmptyObject(res) == false) {
            //                 jQuery.each(res.errors,function(key,value){
            //                     jQuery('#'+key).closest('.form-group').append('<br><small class="text-danger">'+value+'</small>')
            //                 });
            //             }
            //         }
            //     });
            // });

        });
    </script>
@endpush