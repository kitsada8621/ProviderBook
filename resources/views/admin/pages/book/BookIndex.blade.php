@extends('admin.layout.app')
@section('title','จัดการข้อมูลหนังสือโครงงาน')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{{$header}}</h2>
                    <p class="pageheader-text">{{$header}}</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" onclick="location.href='/';" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">หนังสือ</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header justify-content-between d-flex align-items-center">
                        <span style="font-size:16px; font-weight:500;">{{$title}}</span>
                        <div class="form-button">
                            <a href="#" class="btn-add btn btn-outline-light btn-sm"><i class="fas fa-plus"></i>เพิ่มข้อมูล</a>
                            <a href="/book/print" class="btn-print btn btn-outline-light btn-sm"><i class="fas fa-print"></i>พิมพ์</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสโครงงาน</th>
                                        <th class="border-0">ชื่อหนังสือ</th>
                                        <th class="border-0">ประเภทหนังสือ</th>
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
    @include('admin.pages.book.modal')
@endsection
@push('script')
    <script>
    $(function(){
        var table = $('#myTables').DataTable({
            processing: true,
            serverSide: true,
            bInfo: false,
            ajax: "{{ route('admin.getbooks') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'b_id', name: 'b_id'},
                {data: 'p_name', name: 'p_name'},
                {data: 'type', name: 'type'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],columnDefs: [
                { targets: [0,1,3,4], className : 'text-center' }
            ]
        });

        /** Search */
        $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
        });

        /* Insert*/
        $('.btn-add').click(()=>{
            $('#modalIns').modal('show');
            $('.modal-ins-title').text('เพิ่มหนังสือ');
            $('.btn-ins-name').text('บันทึก');
            $('#formIns').find('small').remove();
            document.getElementById('b_id').readOnly = false;
            document.getElementById('b_id').value="";
            $('.form-b_id').hide();
            Clearform();
        });

        /* edit */
        $(document).on('click','.edit',function(){
            $('#modalIns').modal('show');
            $('.modal-ins-title').text('แก้ไขข้อมูลหนังสือ');
            $('.btn-ins-name').text('อัพเดต');
            document.getElementById('b_id').readOnly = true;
            document.getElementById('b_id').value= $(this).data('b_id');
            document.getElementById('p_id').value= $(this).data('p_id');
            document.getElementById('p_name').value= $(this).data('p_name');
            document.getElementById('type').value= $(this).data('type');
            $('.form-b_id').show();
        });

        /* Submit Form Ins */
        $('#formIns').submit((e)=>{
            e.preventDefault();
            $('#formIns').find('small').remove();
            $.ajax({
                type: "POST",
                url: "{{route('admin.book.create')}}",
                data: $('#formIns').serialize(),
                dataType: "JSON",
                success: function (data) {
                    $('#modalIns').modal('hide');
                    table.ajax.reload();
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

        /* Clear Data*/
        let Clearform = ()=>{
            document.getElementById('b_id').value="";
            document.getElementById('p_id').value="";
            document.getElementById('p_name').value="";
            document.getElementById('type').value="";
            document.getElementById('id').value="";
        }

        /* Delete*/
        $(document).on('click','.delete',function(){
            $('#modalDel').modal('show');
            document.getElementById('delid').value= $(this).data('b_id');
        });

        /** details */
        $(document).on('click','.detail',function(){
            $('#modaldetail').modal('show');
            $('.b-id').text($(this).data('b_id'));
            $('.p-name').text($(this).data('p_name'));
            $('.category').text($(this).data('type'));
            $('.type').text($(this).data('category'));
            $('.create-date').text($(this).data('createdate'));
            $('.adviser').text($(this).data('adviser'));
            $('.creator').text($(this).data('creator'));
            $('.description').text($(this).data('description'));
        });

        /* project id search */
        $('#p_id').change(()=>{
            var p_id = document.getElementById('p_id').value;
            $.ajax({
                type: "get",
                url: "/get/project/id",
                data: {id:p_id},
                dataType: "json",
                success: function (data) {
                    if(data.success == true) {
                        document.getElementById('p_name').value=data.p_name;
                    }else {
                        document.getElementById('p_name').value="";
                    }
                }
            });
        });
        /*project name search*/
        $('#p_name').change(()=>{
            var name = document.getElementById('p_name').value;
            $.ajax({
                type: "GET",
                url: "{{route('project.get.name')}}",
                data: {name:name},
                dataType: "json",
                success: function (data) {
                    if(data.success == true) {
                        document.getElementById('p_id').value = data.p_id;
                    }else {
                        document.getElementById('p_id').value="";
                    }
                }
            });
        });

        $('.submit-delete').click((e)=>{
            var id = document.getElementById('delid').value;
            $.ajax({
                type: "DELETE",
                url: "/book/delete/"+id,
                data: {id:id},
                dataType: "json",
                success: function (data) {
                    if(data.success == true) {
                        $('#modalDel').modal('hide');
                        table.ajax.reload();
                    }
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
        .pagination {
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .table-responsive {
            padding: 0;
        }
        table thead tr th {
            font-size: 13px;
            font-weight: 600 !important;
        }
        table tbody tr td {
            font-size: 14px;
            font-weight: 300 !important;
        }
        table tbody tr td a{
            margin: 0px 5px 0px 0px;
        }
        @media (max-width:719px) {
            table tbody tr td a{
                margin: 0px 5px 5px 0px;
            }
        }
        .list-styles:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        }
        .list-styles .detail-title {
            font-size: 13px;
            font-weight: 500 !important;
            padding-left: 20px;
            padding-right: 5px;
        }
        .list-styles .detail-content {
            padding-left: 5px;
            padding-right: 30px;
            font-size: 13px;
            font-weight: 300 !important;
        }
        .form-button a{
            font-size: 14px;
            font-weight: 300;
        }
        .form-button a i {
            font-size: 10px;
            margin-right: 5px;
        }
    </style>
@endpush