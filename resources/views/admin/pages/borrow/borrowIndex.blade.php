@extends('admin.layout.app')
@section('title',$header)
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
                                <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">ยืมหนังสือ</a></li>
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
                        <span class="borrow-title">{{$title}}</span>
                        <a href="/borrow/book" class="btn btn-outline-light btn-sm btn-add">ยืมหนังสือ</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสหนังสือ</th>
                                        <th class="border-0">ชื่อหนังสือ</th>
                                        <th class="border-0">ผู้ยืม</th>
                                        <th class="border-0">วันที่ยืม</th>
                                        <th class="border-0">กำหนดคืน</th>
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
    
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขข้อมูลการยืมหนังสือ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="formEdit">
                <div class="modal-body">
                    @csrf
                    <div class="container-fluid">
                        <input type="hidden" name="id" id="id" readonly>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-12 col-md-12 col-xl-12">
                                <div class="alert alert-errors alert-dismissible fade show" role="alert" style="display:none;"> 
                                    <strong class="alert-message-content"></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="b_id">รหัสหนังสือ</label>
                                    <input id="b_id" class="form-control" type="text" name="b_id">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="p_name">ชื่อหนังสือ</label>
                                    <input id="p_name" class="form-control" type="text" name="p_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_id">รหัสผู้ยืม(นักศึกษา)</label>
                                    <input id="std_id" class="form-control" type="text" name="std_id">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_name">ชื่อผุ้ยืม(นักศึกษา)</label>
                                    <input id="std_name" class="form-control" type="text" name="std_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="br_date">วันที่ยืม</label>
                                    <input id="br_date" class="form-control" type="date" name="br_date">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="due_date">กำหนดคืน</label>
                                    <input id="due_date" class="form-control" type="date" name="due_date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning">อัพเดต</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ลบข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="formDel">
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <input type="text" name="delid" id="delid" readonly>
                        <strong class="small" style="font-size:14px;">ต้องการลบข้อมูล ใช่หรือไม่ ?.</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-danger">ลบข้อมูล</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    
    <!-- Modal Details -->
    <div class="modal fade" id="modaldetails" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดการยืม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body p-0">
                    <ul class="list-group">
                        <li class="list-group-item"><strong class="details-title">รหัสหนังสือ</strong>:<span class="details-content p-id"></span></li>
                        <li class="list-group-item"><strong class="details-title">ชื่อหนังสือ</strong>:<span class="details-content p-name"></span></li>
                        <li class="list-group-item"><strong class="details-title">ประเภทหนังสือ</strong>:<span class="details-content category"></span></li>
                        <li class="list-group-item"><strong class="details-title">ผู้ยืม</strong>:<span class="details-content std-name"></span></li>
                        <li class="list-group-item"><strong class="details-title">วันที่ยืม</strong>:<span class="details-content br-date"></span></li>
                        <li class="list-group-item"><strong class="details-title">กำหนดคืน</strong>:<span class="details-content due-date"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(document).ready(()=>{

            const table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: '{{route('borrow.getBorrows')}}',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'b_id',name:'b_id'},
                    {data:'p_name',name:'p_name'},
                    {data:'std_name',name:'std_name'},
                    {data:'br_date',name:'br_date'},
                    {data:'due_date',name:'due_date'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ],
                columnDefs: [
                   { targets: [0,1,3,4,5,6],
                    className: 'text-center' }
                ]
            });

            /**Realtime Searching */
            $('.search-control').keyup(function(){
                table.search($(this).val()).draw();
            });

            /** Edit control */
            $(document).on('click','.edit',function(){
                $('#modalEdit').modal('show');
                document.getElementById('id').value = $(this).data('br_id');
                document.getElementById('std_id').value = $(this).data('std_id');
                document.getElementById('std_name').value = $(this).data('std_name');
                document.getElementById('b_id').value = $(this).data('b_id');
                document.getElementById('p_name').value = $(this).data('p_name');
                document.getElementById('br_date').value = $(this).data('br_date');
                document.getElementById('due_date').value = $(this).data('due_date');
                $('#formEdit').find('small').remove();
            });

            $('#formEdit').submit((e)=>{
                e.preventDefault();
                $('#formEdit').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('borrow.edit')}}",
                    data: $('#formEdit').serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#modalEdit').modal('hide');
                            table.ajax.reload();
                        }else {
                            alert(data.msg);
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

            $(document).on('click','#delete',function(){
                $('#modalDel').modal('show');
                $('#delid').val($(this).data('id'));
                document.getElementById('delid').style.display = 'none';
            });

            $(document).on('submit','#formDel',()=>{
                let id = document.getElementById('delid').value;
                $.ajax({
                    type: "DELETE",
                    url: "/borrow/delete/"+id,
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        $('#modalDel').modal('hide');
                        table.ajax.reload();
                    }
                });
            });

            $(document).on('click','.details',function(){
                $('#modaldetails').modal('show');
                $('.p-id').text($(this).data('b_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.category').text($(this).data('type'));
                $('.std-name').text($(this).data('std_name'));
                $('.br-date').text($(this).data('br_date'));
                $('.due-date').text($(this).data('due_date'));
            });


            /** TextBox search */
            document.getElementById('b_id').addEventListener('keyup',()=>{
                const id = document.getElementById('b_id').value;
                
                $.ajax({
                    type: "GET",
                    url: "{{route('borrow.get.book.id')}}",
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            document.getElementById('p_name').value = data.p_name;
                        }else {
                            document.getElementById('p_name').value="";
                        }
                    }
                });

            });
            document.getElementById('p_name').addEventListener('keyup',()=>{
                const name = document.getElementById('p_name').value;
                $.ajax({
                    type: "GET",
                    url: "{{route('borrow.get.book.name')}}",
                    data: {name:name},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            document.getElementById('b_id').value = data.b_id;
                        }else {
                            document.getElementById('b_id').value = "";
                        }
                    }
                });
            });
            document.getElementById('std_id').addEventListener('keyup',()=>{
                const id = document.getElementById('std_id').value;
                $.ajax({
                    type: "GET",
                    url: "{{route('student.get.show')}}",
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            document.getElementById('std_name').value=data.std_name;
                        }else {
                            document.getElementById('std_name').value="";
                        }
                    }
                });
            });
            document.getElementById('std_name').addEventListener('keyup',()=>{
                const name = document.getElementById('std_name').value;
                $.ajax({
                    type: "GET",
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
    .dataTables_length,
        .dataTables_filter {
            display: none;
        }
    .borrow-title {
        font-size: 16px; 
        font-weight: 500;
    }
    .btn-add {
        font-size: 14px;
        font-weight: 300;
    }
    .table-responsive {
        padding: 0;
    }
    table {
        padding: 0;
    }
    table thead tr th {
        font-size: 13px !important;
        font-weight: 500 !important;
        color: gray !important;
    }
    table tbody tr td {
        font-size: 14px !important;
        font-weight: 300 !important;
    }
    table tbody tr td a{
        margin: 0px 5px 0px 0px;
    }
    @media (max-width:1182px) {
        table tbody tr td a{
            margin: 0px 5px 5px 0px;
        }
    }
    .pagination {
        padding: 10px 10px;
    }
    .list-group-item:nth-of-type(odd) {
        background-color: rgba(230, 230, 242, .5)
    }
    .list-group-item strong {
        font-size: 13px;
        font-weight: 500 !important;
        padding-left: 10px;
        margin-right: 5px;
    }
    .list-group-item span {
        font-size: 13px;
        font-weight: 300 !important;
        padding-left: 5px;
    }
    </style>
@endpush