@extends('admin.layout.app')
@section('title','จัดการข้อมูลผู้ใข้งาน')
@section('content')

<div class="container-fluid  dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">จัดการข้อมูลผู้ดูแล</h2>
                <p class="pageheader-text">จัดการข้อมูลผู้ดูแล</p>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                            <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">ผู้ดูแล</a></li>               
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- ============================================================== -->
        <!-- basic table  -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    ข้อมูลผู้ดูแล
                    <button class="btn btn-outline-light btn-sm create" type="button">เพิ่มข้อมูล(Account)</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr class="border-0">
                                    <th class="border-0">#</th>
                                    <th class="border-0">ชื่อ-สกุล</th>
                                    <th class="border-0">ตำแหน่ง</th>
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
        <!-- ============================================================== -->
        <!-- end basic table  -->
        <!-- ============================================================== -->
    </div>
</div>
@include('admin.pages.users.popup')
@endsection
@push('script')
    <script>
        $(function(){
            /** Tables */
            var table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: "{{ route('getAdmins') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'position', name: 'position'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],columnDefs: [
                    { targets: [0,1,2,3], className : 'text-center' }
                ]
            });
            
            /** Search */
            $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
            });

            /** create */
            $('.create').click(function() {
                $('#modalIns').modal('show');
                $('.Ins-title').text('เพิ่มข้อมูลผู้ใช้งาน');
                clearForm();
                $('#formIns').find('small').remove();
                $('.poin-profile').hide();
            });

            function clearForm() {
                $('#id').val('');
                $('#name').val('');
                $('#email').val('');
                $('#position').val('');
                $('#username').val('');
                $('#password').val('');
                $('#conformpassword').val('');
                $('#image').val('');
            }

            /** edit */
            $(document).on('click','.edit',function(){
                $('#modalIns').modal('show');
                $('.Ins-title').text('แก้ไขข้อมูลผู้ใช้งาน');
                $('#id').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#email').val($(this).data('email'));
                $('#position').val($(this).data('position'));
                $('#username').val($(this).data('username'));
                $('#password').val($(this).data('password'));
                $('#conformpassword').val($(this).data('password'));
                $('#image').val('');
                $('.poin-profile').show();
                if($(this).data('image') == "" ) {
                    $('.img-profile').html('<strong style="font-size:14px;" class="text-danger small">ไม่มีรูปภาพ</strong>');
                }else {
                    $('.img-profile').html('<img width="60" height="auto" src="uploads/'+$(this).data('image')+'">');
                }
                $('#formIns').find('small').remove();
            }); 

            /** Create and Edit */
            $('#formIns').submit(function (e){
                e.preventDefault();
                $('#formIns').find('small').remove();

                $.ajax({
                    type: "POST",
                    url: "{{route('admin.create.submit')}}",
                    data: new FormData(this),
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if(data.success == true) {
                            $('#modalIns').modal('hide');
                            table.ajax.reload();
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

            /** delete */
            $(document).on('click','.delete',function(){
                $('#modalDel').modal('show');
                $('#delid').val($(this).data('id'));
            });

            /** del submit */
            $('.btn-dels').click(function(e){
                e.preventDefault();
                var id = $('#delid').val();
                var token = $(this).data('token');
              
                $.ajax({
                    type: "DELETE",
                    url: '/admins/delete/'+id+'',
                    data: {id:id,_token:token},
                    dataType: "json",
                    success: function (data) {
                        $('#modalDel').modal('hide');
                        table.ajax.reload();
                    },error: function (xhr) {
                        console.log(error);
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
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }
        .card-header {
            font-size: 16px;
            font-weight: 500;
        }
        .card-header button {
            font-weight: 14px;
            font-weight: 300;
        }
        table thead tr th {
            font-size:13px; 
            font-weight: 600 !important;
        }
        table tbody tr td {
            font-size: 14px;
            font-weight: 300 !important;
        }
        table tbody tr td a{
            margin: 0px 5px 0px 0px;
        }
        @media (max-width:400px) {
            table tbody tr td a{
                margin: 0px 5px 5px 0px;
            }
        }
        .pagination {
            padding: 10px;
        }
    </style>
@endpush