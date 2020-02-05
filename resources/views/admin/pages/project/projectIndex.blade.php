@extends('admin.layout.app')
@section('title','จัดการข้อมูลโครงงาน')
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
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">โครงงาน</a></li>
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
                        <a href="#" class="btn btn-outline-light btn-sm project-add">เพิ่มโครงงาน</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-0">
                            <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสโครงงาน</th>
                                        <th class="border-0">ชื่อโครงงาน</th>
                                        <th class="border-0">ประเภทโครงงาน</th>
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
    @include('admin.pages.project.popup')

@endsection
@push('script')
    <script>
        $(document).ready(()=>{
            /* Tables */
            var table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: "{{ route('getProject') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'p_id', name: 'p_id'},
                    {data: 'p_name', name: 'p_name'},
                    {data: 'category', name: 'category'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],columnDefs: [
                    { targets: [0,1,3,4], className : 'text-center' }
                ]
            });

            /** Search */
            $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
            });

            /* add */
            $('.project-add').click(()=>{
                $('#modalIns').modal('show');
                $('.ins-title').text('เพิ่มข้อมูลโครงงาน');
                $('.btn-ins-name').text('บันทึก');
                $('#formIns').find('small').remove();
                $('#id').val('');
                $('#formIns')[0].reset();
            });

            /* Edit */

            $(document).on('click','.edit',function(){
                $('#modalIns').modal('show');
                $('.ins-title').text('แก้ไขข้อมูลนักศึกษา');
                $('.btn-ins-name').text('อัพเดต');                
                $('#id').val($(this).data('p_id'));
                $('#p_name').val($(this).data('p_name'));
                $('#category').val($(this).data('category'));
                $('#t_id').val($(this).data('t_id'));
                $('#adviser').val($(this).data('t_name'));
                $('#std_id').val($(this).data('std_id'));
                $('#creator').val($(this).data('std_name'));
                $('#createdate').val($(this).data('createdate'));
                $('#description').val($(this).data('description'));
                $('#formIns').find('small').remove();
            });

            /** Submit create or edit */
            $('#formIns').submit((e)=>{
                e.preventDefault();
                $('#formIns').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.p.create')}}",
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

            /* Delete */
            $(document).on('click','.delete',function(){
                $('#modalDel').modal('show');
                $('#iddel').val($(this).data('id'));
            });

            /* Delete Submit*/
            $('#formDel').submit(()=>{
                var id = document.getElementById('iddel').value;
                var token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    type: "DELETE",
                    url: "/projects/delete/"+id,
                    data: {
                        id:id,
                        _token:token
                    },
                    dataType: "json",
                    success: function (data) {
                        $('#modalDel').modal('hide');
                        table.ajax.reload();
                    }
                });
            });


            $(document).on('click','.detail',function(){
                $('#modaldetail').modal('show');
                $('.p-id').text($(this).data('p_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.category').text($(this).data('category'));
                $('.t-details').text($(this).data('t_name'));
                $('.std-details').text($(this).data('std_name'));
                $('.create-date').text($(this).data('createdate'));
                $('.description').text($(this).data('description'));
            });

            /** textbox chang to database on show */
            $('#std_id').change(()=>{
                var id = document.getElementById('std_id').value;
                if(id != "") {
                    $.ajax({
                        type: "GET",
                        url: "{{route('student.get.show')}}",
                        data: {id:id},
                        dataType: "json",
                        success: function (data) {
                            if(data.success == true) {
                                document.getElementById('creator').value = data.std_name;
                            }else {
                                document.getElementById('creator').value = "";
                            }
                        }
                    });
                }else {
                    document.getElementById('creator').value ="";
                }
            });

            $('#creator').change(()=>{
                var name = document.getElementById('creator').value;
                if(name != "") {    
                    $.ajax({
                        type: "GET",
                        url: "{{route('student.get.show.name')}}",
                        data: {name:name},
                        dataType: "json",
                        success: function (data) {
                            if(data.success == true) {
                                document.getElementById('std_id').value = data.std_id;
                            }else {
                                document.getElementById('std_id').value ="";
                            }
                        }
                    });
                }else {
                    document.getElementById('std_id').value="";
                }
            });

            $('#t_id').change(()=>{
                var id = document.getElementById('t_id').value;
                if(id != "") {
                    $.ajax({
                        type: "GET",
                        url: "{{route('teacher.get.id')}}",
                        data: {id:id},
                        dataType: "json",
                        success: function (data) {
                            if(data.success == true) {
                                document.getElementById('adviser').value = data.t_name;
                            }else {
                                document.getElementById('adviser').value ="";
                            }
                        }
                    });
                }else {
                    document.getElementById('adviser').value="";
                }
            });
            document.getElementById().addEventListener
            $('#adviser').change(()=>{
                var name = document.getElementById('adviser').value;
                if(name != "") {
                    $.ajax({
                        type: "GET",
                        url: "{{route('teacher.get.name')}}",
                        data: {name:name},
                        dataType: "json",
                        success: function (data) {
                            if(data.success == true) {
                                document.getElementById('t_id').value = data.t_id;
                            }else {
                                document.getElementById('t_id').value="";
                            }
                        }
                    });
                }else {
                    document.getElementById('t_id').value= "";
                }
            });
            /** end textbox chang to database on show */

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
        .project-add {
            font-size: 14px;
            font-weight: 300;
        }.pagination {
            padding: 10px 10px;
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
        @media (max-width:730px) {
            table tbody tr td a{
                margin: 0px 5px 5px 0px;
            }
        }
        .list-items:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        }
        .list-group-item {
            padding: 16px 20px 16px 40px;
        }
        .list-group-item .detail-title {
            font-size: 13px;
            font-weight: 500 !important;
            margin-right: 5px !important;
        }

        .list-group-item .detail-content {
            font-size: 14px;
            font-weight: 300 !important;
            padding-left: 15px !important;
        }

        .description {
            text-indent: 2.5rem;
            font-size: 14px;
            font-weight: 300 !important;
        }
    </style>
@endpush