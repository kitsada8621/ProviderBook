@extends('admin.layout.app')
@section('title',$header)
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{{$header}}</h2>
                    <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">ต่ออายุการยืม</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{{$header}}</h5>
                    <div class="card-body p-0">
                        <div class="col-12 col-sm-12 col-md-8 col-lg-7 col-xl-6 mx-auto">
                            <form id="formRenew" class="mt-4 mb-4">
                                @csrf
                                <div class="form-group">
                                    <label for="std_id">รหัสนักศึกษา</label>
                                    <input id="std_id" class="form-control" type="text" name="std_id">
                                </div>
                                <div class="form-group">
                                    <label for="std_name">ชื่อนักศึกษา</label>
                                    <input id="std_name" class="form-control" type="text" name="std_name">
                                </div>
                                <div class="form-group">
                                    <label for="password">รหัสผ่าน</label>
                                    <input id="password" class="form-control" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.pages.Renew.modal')

@endsection
@push('script')
    <script>
        $(document).ready(()=>{

            $('.search-control').hide();

            // let table = $('#myTables').DataTable({
            //     processing: true,
            //     serverside: true,
            //     bInfo: false,
            //     ajax: "{{route('renew.get.student')}}",
            //     columns:[
            //         {data:'DT_RowIndex',name:'DT_RowIndex'},
            //         {data:'std_id',name:'std_id'},
            //         {data:'std_name',name:'std_name'},
            //         {data:'major',name:'major'},
            //         {data:'action',name:'action',orderable:false,searchable:false},
            //     ],columnDefs:[
            //         {targets:[0,1,3,4],className:'text-center'},
            //         {targets:[2],className:'p-3'}
            //     ]
            // });

            // $('.search-control').keyup(()=>{
            //     table.search($('.search-control').val()).draw();
            // });

            $('#formRenew').submit((e)=>{
                e.preventDefault();
                $('#formRenew').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('renew.submit')}}",
                    data: $('#formRenew').serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#modalRenew').modal('show');
                            $('.renew-title').text(data.title);
                            $('.modal-contents').text(data.msg);
                            $('.btn-close').addClass('btn-success');
                            $('#formRenew')[0].reset();
                        }else {
                            $('#modalRenew').modal('show');
                            $('.renew-title').text("เกิดข้อผิดพลาด");
                            $('.modal-contents').text(data.msg);
                            $('.btn-close').addClass('btn-danger');
                            $('#formRenew')[0].reset();
                        }
                    },error: function (xhr) {
                        var res = xhr.responseJSON;
                        if (jQuery.isEmptyObject(res) ==false ) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key)
                                    .closest('.form-group')
                                    .addClass('.has-error')
                                    .append('<small id="helpId" class="text-danger">'+value+'</small>');
                            });
                        }
                    }
                });


            });

            document.getElementById('std_id').addEventListener('keyup',()=>{
                let id = document.getElementById('std_id').value;
                $.ajax({
                    type: "get",
                    url: "{{route('student.get.show')}}",
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            document.getElementById('std_name').value = data.std_name;
                        }else {
                            document.getElementById('std_name').value="";
                        }
                    }
                });
            });

            document.getElementById('std_name').addEventListener('keyup',()=>{
                let name = document.getElementById('std_name').value;
                $.ajax({
                    type: "get",
                    url: "{{route('student.get.show.name')}}",
                    data: {name:name},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            document.getElementById('std_id').value=data.std_id;
                        }else {
                            document.getElementById('std_id').value="";
                        }
                    }
                });
            });

        });
    </script>
@endpush
@push('style')
    <style>
        .dataTables_wrapper .dataTables_length {
            display: none;
        }
        .dataTables_wrapper .dataTables_filter {
            display: none;
        }
        .pagination {
            padding: 10px 10px;
        }
    </style>
@endpush