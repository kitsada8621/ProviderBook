@extends('student.layouts.app')
@section('title','โครงงาน')
@section('content')
    
    <div class="container-fluid dashboard-content">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">จัดการข้อมูลโครงงาาน</h2>
                    <p class="pageheader-text">จัดการข้อมูลโครงงาาน</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/user/student/home" class="breadcrumb-link">หน้าหลัก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">โครงงาน</a></li>
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
                        ข้อมูลโครงงาน
                        <button class="btn btn-outline-light btn-sm" onclick="$('#modalIns').modal('show');$('.btn-ins-name').text('บันทึก');$('.ins-title').text('เพิ่มข้อมูลโครงงาน');$('#formIns').find('small').remove();$('#formIns')[0].reset();" type="button">เพิ่มโครงงาน</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped myTables" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสโครงงาน</th>
                                        <th class="border-0">ชื่อโครงงาน</th>
                                        <th class="border-0">ประเภทโครงงาน</th>
                                        <th class="border-0">จัดการ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('student.pages.project.projectPopup')

@endsection
@push('script')
    <script>
        $(document).ready(()=>{

            let table = $('.myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: '{{route('users.p.home')}}',
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'p_id',name:'p_id',orderable:false},
                    {data:'p_name',name:'p_name',orderable:false},
                    {data:'category',name:'category',orderable:false},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ],columnDefs:[
                    {targets:[0,1,2,3,4],className:'text-center'}
                ]
            });
            
            $('.search-control').keyup(()=>{
                table.search($('.search-control').val()).draw();
            });

            const modalInsert = $('#modalIns');
            const formInsert = $('#formIns');

            formInsert.submit((e)=>{
                e.preventDefault();
                formInsert.find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('users.p.create')}}",
                    data: formInsert.serialize(),
                    dataType: "json",
                    success: function (data) {
                        modalInsert.modal('hide');
                        table.ajax.reload();
                    },error: function (err) {
                        var res = err.responseJSON;
                        if (jQuery.isEmptyObject(res) ==false ) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key)
                                    .closest('.form-group').append('<small id="helpId" class="text-danger">'+value+'</small>');
                            });
                        }
                    }
                });
            });

            $(document).on('click','.edit',function(){
                modalInsert.modal('show');
                $('.ins-title').text('แก้ไขข้อมูลโครงงาน');
                $('.btn-ins-name').text('อัพเดต');
                $('#id').val($(this).data('p_id'));
                $('#p_name').val($(this).data('p_name'));
                $('#category').val($(this).data('category'));
                $('#createdate').val($(this).data('createdate'));
                $('#std_id').val($(this).data('std_id'));
                $('#std_name').val($(this).data('std_name'));
                $('#t_id').val($(this).data('t_id'));
                $('#t_name').val($(this).data('t_name'));
                $('#description').val($(this).data('description'));
            });

            /** details */
            $(document).on('click','.detail',function(){
                $('#modal_detail').modal('show');
                $('.p-id').text($(this).data('p_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.p-type').text($(this).data('category'));
                $('.p-date').text($(this).data('createdate'));
                $('.std-name').text($(this).data('std_name'));
                $('.std-major').text($(this).data('major'));
                $('.t-name').text($(this).data('t_name'));
                $('.text-description').text($(this).data('description'));
            });
            /** end details */

            $('#t_id').keyup(()=>{
                const id = $('#t_id').val();
                $.ajax({
                    type: "get",
                    url: "{{route('teacher.get.id')}}",
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#t_name').val(data.t_name);
                        }else {
                            $('#t_name').val('');
                        }
                    }
                });
            });

            $('#t_name').keyup(()=>{
                const name = $('#t_name').val();
                $.ajax({
                    type: "get",
                    url: "{{route('teacher.get.name')}}",
                    data: {name:name},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#t_id').val(data.t_id);
                        }else {
                            $('#t_id').val('');
                        }
                    }
                });
            });

        });
    </script>
@endpush
@push('style')
    <style>
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
        .dataTables_length,
        .dataTables_filter{
            display: none;
        }.pagination {
            padding: 10px;
        }
        table tbody tr td a {
            margin-right: 5px;
        }
        @media (max-width:670px) {
            table tbody tr td a {
                margin: 0px 5px 5px 0px;
            }
        }
        .list-group .list-group-item:nth-of-type(odd){
            background-color: rgba(230, 230, 242, .5);
        }
        .list-group .li-odd {
            padding-left: 30px;
        }
        .description-title {
            font-size: 14px;
            font-weight: 500;
            margin-top: 15px;
        }
        .text-description {
            font-size: 14px;
            font-weight: 300;
            padding-bottom: 30px;
            text-indent: 2rem;
        }
    </style>
@endpush