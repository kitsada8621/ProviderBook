@extends('admin.layout.app')
@section('title','แก้ไขรหัสผ่าน')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <h5 class="card-header">แก้ไขรหัสผ่าน</h5>
                    <div class="card-body">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 mx-auto">
                            <form id="Updates">
                                @csrf
                                <div class="form-group">
                                    <label for="pass_old">รหัสผ่านเดิม</label>
                                    <input id="pass_old" class="form-control" type="password" name="pass_old">
                                </div>
                                <div class="form-group">
                                    <label for="pass_new">รหัสผ่านใหม่</label>
                                    <input id="pass_new" class="form-control" type="password" name="pass_new">
                                </div>
                                <div class="form-group">
                                    <label for="pass_same">ยืนยัน รหัสผ่านใหม่</label>
                                    <input id="pass_same" class="form-control" type="password" name="pass_same">
                                </div>
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-light" onclick="location.href='/'" >ยกเลิก</button>
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
@push('style')
    <style>
        .form-group label, .form-group input {
            font-size: 14px;
            font-weight: 300;
        }

        .form-group button {
            font-size: 14px;
            font-weight: 500;
        }
        .search-control {
            display: none;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(()=>{

            const Updates = $('#Updates');
            Updates.submit((e)=>{
                e.preventDefault();
                const id = "{{Auth::user()->id}}";
                Updates.find('small').remove();
                $.ajax({
                    type: "PUT",
                    url: "/admin/password/"+id,
                    data: Updates.serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        if(data.success == true) {
                            alert(data.message);
                            location.href="{{route('logout')}}";
                        }else {
                            alert(data.message);
                            Updates[0].reset();
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