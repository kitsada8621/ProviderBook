@extends('admin.layout.app')
@section('title','จัดการข้อมูลนักศึกษา')
@section('content')
    <div class="container-fluid  dashboard-content">
       
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{{$header}}</h2>
                    <p class="pageheader-text">{{$header}}</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">นักศึกษา</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
     
        <div class="row">
           
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{$title}}
                        <div class="section-button">
                            <button class="btn btn-outline-light btn-sm book-add" type="button"><i class="fas fa-plus"></i>เพิ่มข้อมูล(นักศึกษา)</button>                
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-0">
                            <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสนักศึกษา</th>
                                        <th class="border-0">ชื่อ-สกุล</th>
                                        <th class="border-0">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody >
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('admin.pages.student.popup')
@endsection
@push('script')
    <script>
        $(function(){

            var table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: "{{ route('std.getStudent') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'std_id', name: 'std_id', orderable: false},
                    {data: 'std_name', name: 'std_name', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],columnDefs: [
                    { targets: [0,1,2,3], className : 'text-center' }
                ]
            });

            /** Search */
            $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
            });

            /** modal */
            var modalIns = $('#modalIns');
            var modalDel = $('#modalDel');

            /** Inserting */
            $('.book-add').click(function(){
                modalIns.modal('show');
                $('.btn-Ins-name').text('บันทึก');
                $('#formIns').find('small').remove();
                $('#id').val('');
                $('.Ins-title').text('เพิ่มข้อมูลนักศึกษา');
                document.getElementById('std_id').readOnly = false;
                clearform();
                $('.example-profile').hide();
            });

            /** clear */
            function clearform() {
                $('#std_id').val('');
                $('#std_name').val('');
                $('#email').val('');
                $('#tel').val('');
                $('#major').val('');
                $('#password').val('');
                $('#confirmpassword').val('');
                $('#image').val('');
            }

            /** add or edit submit to database */
            $('#formIns').submit(function(e){
                e.preventDefault();
                $('#formIns').find('small').remove();
                $.ajax({
                    type: "post",
                    url: '{{route('std.create')}}',
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if(data.success == true) {
                            modalIns.modal('hide');
                            table.ajax.reload();
                            clearform();
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

            /** edit */
            $(document).on('click','.edit',function(){
                modalIns.modal('show');
                $('#id').val($(this).data('id'));
                $('.Ins-title').text('แก้ไขข้อมูลนักศึกษา');
                $('.btn-Ins-name').text('อัพเดต');
                $('#formIns').find('small').remove();
                document.getElementById('std_id').readOnly = true;

                $('#std_id').val($(this).data('id'));
                $('#std_name').val($(this).data('std_name'));
                $('#email').val($(this).data('email'));
                $('#tel').val($(this).data('tel'));
                $('#major').val($(this).data('major'));
                $('#password').val($(this).data('password'));
                $('#confirmpassword').val($(this).data('password'));

                $('.example-profile').show();

                if($(this).data('image') == "") {
                    $('.img-profile').html('<strong class="small text-danger" style="font-size:14px;">ไม่มีรูป</strong>')
                }else {
                    $('.img-profile').html('<img src="/uploads/'+$(this).data('image')+'" width="60" height="auto">')
                }

            });

            /** Delete */
            $(document).on('click','.delete',function(){
                modalDel.modal('show');
                $('#des_id').val($(this).data('id'));
            });

            $('#formDels').submit(function (e){
                e.preventDefault();
                var id = $('#des_id').val();
                var token = $("meta[name='csrf-token']").attr("content");
                
                $.ajax({
                    type: "DELETE",
                    url: "/std/destroy/"+id,
                    data: {
                        id:id,
                        _token:token
                    },
                    success: function (response) {
                        modalDel.modal('hide');
                        table.ajax.reload();
                    }
                });

            });

            $(document).on('click','.detail',function(){
                $('#modaldetails').modal('show');
                $('.std-id').text($(this).data('std_id'));
                $('.std-name').text($(this).data('std_name'));
                $('.std-major').text($(this).data('major'));
                $('.std-email').text($(this).data('email'));
                $('.std-tel').text($(this).data('tel'));
                if($(this).data('image') != "") {
                    $('.myprofile').html('<img src="/uploads/'+$(this).data('image')+'" width="150" height="150" class="rounded-circle" alt="profiles">');
                }else {
                    $('.myprofile').html('<img src="https://icon-library.net/images/anonymous-avatar-icon/anonymous-avatar-icon-25.jpg" width="150" height="150" class="rounded-circle" alt="profiles">');
                }

                
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
        .card-header {
            font-size: 16px;
            font-weight: 500;
        }
        .pagination {
            padding: 10px;
        }
        table thead tr th {
            font-size: 13px;
            font-weight: 600 !important;
        }
        table tbody tr td {
            font-size: 14px;
            font-weight: 300 !important;
        }
        table tbody tr td .btn{
            margin: 0px 5px 0px 0px;
        }
        @media (max-width:518px) {
            table tbody tr td .btn{
                margin: 0px 5px 5px 0px;
                font-size: 10px;
            }
        }
        .list-group .list-group-item {
            border: none;
            padding: 7px 15px 7px 30px;
        }
        .list-group .list-group-item:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        }
        .detail-title {
            font-size: 13px;
            font-weight: 500;
            margin-right: 10px;
        }
        .detail-content {
            padding-left: 10px;
            font-size: 13px;
            font-weight: 300;
        }
        .section-button button {
            font-size: 14px;
            font-weight: 400 !important;
        }
        .section-button button i {
            margin-right: 5px;
            font-size: 10px;
        }
    </style>
@endpush