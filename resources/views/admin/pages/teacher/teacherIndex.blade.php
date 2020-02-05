@extends('admin.layout.app')
@section('title','จัดการข้อมูลอาจารย์')
@section('content')
    <div class="container-fluid dashboard-content">

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{{$header}}</h2>
                    <p class="pageheader-text">{{$header}}</p>
                    <div class="page-breadcrumb">
                        <nav class="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="/teacher" class="breadcrumb-link">อาจารย์</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{$title}}
                        <button class="btn btn-outline-light btn-sm" id="btn_add">เพิ่มข้อมูล</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-0">
                            <table class="table myTables table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('admin.pages.teacher.modal')
@endsection
@push('script')
    <script>
        $(document).ready(()=>{

            let table = $('.myTables').DataTable({
                processing:true,
                serverSide:true,
                bInfo:false,
                ajax:"{{route('admin.t.get')}}",
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:"t_name",name:"t_name"},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ],columnDefs:[
                    {targets:[0,1,2],className:'text-center'}
                ]
            });

            $('.search-control').keyup(()=>{
                table.search($('.search-control').val()).draw();
            });

            const modalInserting = $('#modalIns');
            const formInserting = $('#formIns');
            const modalDeleting = $('#modalDel');

            $('#btn_add').click(()=>{
                modalInserting.modal('show');
                $('.ins-title').text('เพิ่มข้อมูลอาจารย์');
                $('.btn-ins-name').text('บันทึก');
                formInserting.find('small').remove();
                $('#t_id').val('');
                $('#t_name').val('');
            });

            $(document).on('click','.edit',function(){
                modalInserting.modal('show');
                $('.ins-title').text('แก้ไขข้อมูลอาจารย์');
                $('.btn-ins-name').text('อัพเดต');
                $('#t_id').val($(this).data('id'));
                $('#t_name').val($(this).data('name'));
                formInserting.find('small').remove();
            });

            formInserting.submit((e)=>{
                e.preventDefault();
                formInserting.find('small').remove();
                $.ajax({
                    type: "post",
                    url: "/teacher/create",
                    data: formInserting.serialize(),
                    dataType: "json",
                    success: function (data) {
                        modalInserting.modal('hide');
                        table.ajax.reload();
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

            $(document).on('click','.delete',function(){
                modalDeleting.modal('show');
                $('#delid').val($(this).data('id'));
            });

            $('.yes-delete').click(()=>{
                const id = $('#delid').val();
                $.ajax({
                    type: "DELETE",
                    url: "/teacher/delete/"+id,
                    data: {id:id},
                    dataType: "JSON",
                    success: function (data) {
                        modalDeleting.modal('hide');
                        table.ajax.reload();
                    }
                });
            });

        });
    </script>
@endpush
@push('style')
    <style>
        .dataTables_length,
        .dataTables_filter {
            display: none;
        }
        .card-header {
            font-size: 16px;
            font-weight: 500;
        }
        .card-header button {
            font-size: 14px;
            font-weight: 300;
        }
        table thead tr th {
            font-size: 13px; 
            font-weight: 600 !important;
        }
        table tbody tr td {
            font-size: 14px; 
            font-weight: 300 !important;
        }
        .pagination {
            padding: 10px;
        }
        .myTables thead tr , 
        .myTables thead tr th {
            border: none;
        }
        .myTables tbody tr td button {
            margin: 0px 5px 0px 0px;
        }
        @media (max-width:385px) {
            .myTables tbody tr td button {
                margin: 0px 5px 5px 0px;
            }
        }
    </style>
@endpush