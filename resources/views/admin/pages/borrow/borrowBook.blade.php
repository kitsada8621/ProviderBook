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
                                <li class="breadcrumb-item"><a href="#" onclick="/borrow" class="breadcrumb-link">ยืมหนังสือ</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">เพิ่มข้อมูลยืมหนังสือ</a></li>
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
                        <a href="/borrow" class="btn btn-outline-light btn-sm btn-add">ข้อมูลการยืม (กลับ)</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสหนังสือ</th>
                                        <th>ชื่อหนังสือ</th>
                                        <th>ประเภทหนังสือ</th>
                                        <th>ประเภทโครงงาน</th>
                                        <th>ยืม</th>
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

    <!-- Modal -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มข้อมูลการยืม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="formData">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" readonly>
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_id">รหัสผู้ยืม(นักศึกษา)</label>
                                    <input id="std_id" class="form-control" type="text" name="std_id">
                                    <strong class="small text-danger error-std"></strong>
                                </div>   
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_name">ชื่อผู้ยืม(นักศึกษา)</label>
                                    <input id="std_name" class="form-control" type="text" name="std_name">
                                    <strong class="small text-danger error-std"></strong>
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="due_date">กำหนดคืน</label>
                                    <input id="due_date" class="form-control" type="date" name="due_date" min="{{date('Y-m-d')}}">
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-success">ยืนยันการยืม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(document).ready(()=>{
            /** DataTables */
            const table =  $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: "{{route('borrow.getbooks')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'b_id', name: 'b_id'},
                    {data: 'p_name', name: 'p_name'},
                    {data: 'type', name: 'type'},
                    {data: 'category', name: 'category'},
                    {data: 'action', name: 'action',orderable: false, seaarchable: false}
                ],columnDefs: [
                    {
                        targets: [0,1,3,4,5],
                        className: 'text-center'
                    }
                ]
            });
            /**Realtime Searching */
            $('.search-control').keyup(function(){
                table.search($(this).val()).draw();
            });
            /** confirm Borrow */
            $(document).on('click','#btnBorrow',function(){
                $('#modalConfirm').modal('show');
                clearForm();
                $('#formData').find('small').remove();
                document.getElementById('id').value = $(this).data('b_id');
                $('.error-std').text('');
            });
            /** clear form */
            let clearForm = ()=>{
                document.getElementById('std_id').value="";
                document.getElementById('std_name').value="";
                document.getElementById('due_date').value="";
            }

            $('#formData').submit((e)=>{
                e.preventDefault();
                $('#formData').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: '{{route('borrow.create')}}',
                    data: $('#formData').serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('.error-std').text('');
                            $('#modalConfirm').modal('hide');
                            window.location.href="/borrow";
                        }else {
                            $('.error-std').text(data.msg);
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

            /** textbox searching */
            document.getElementById('std_id').addEventListener('keyup',(event)=>{
                event.preventDefault();
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
            document.getElementById('std_name').addEventListener('keyup',(event)=>{
                event.preventDefault();
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
        .card-header {
            font-size: 16px !important;
            font-weight: 500 !important;
        }
        .btn-add {
            font-size: 14px !important;
            font-weight: 300 !important;
        }
        .card-body {
            padding: 0;
        }
        .table-responsive {
            padding: 0;
        }
        table thead tr th  {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: gray !important;
        }
        table tbody tr td {
            font-size: 14px;
            font-weight: 300 !important;
        } 
        .pagination {
            padding: 10px 10px;
        }
    </style>
@endpush