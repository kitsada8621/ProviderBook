@extends('admin.layout.app')
@section('title','จัดการข้อมูลสาขา')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{{$header}}</h2>
                    <p class="pageheader-text">{{$header}}</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">สาขา</a></li>
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
                        <button type="button" class="btn btn-outline-light btn-sm major-add">เพิ่มสาขา</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">สาขา</th>
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
    
    <!-- Modal create and edit -->
    <div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title Ins-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="formIns">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" name="id" id="id" readonly>
                            <div class="form-group">
                                <label for="name">ชื่อสาขา</label>
                                <input id="name" class="form-control" type="text" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary btn-ins-name"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
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
                        <input type="hidden" name="dels_id" id="dels_id" readonly>
                        <div class="text-center">
                            <span>ต้องการลบข้อมูล ใช่หรือไม่ ?.</span>
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

@endsection
@push('script')
    <script>
        $(function(){

            var table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: "{{ route('getmajor') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],columnDefs: [
                    { targets: [0,1,2], className : 'text-center' }
                ]
            });

            /** Search */
            $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
            });

            /** add */
            $('.major-add').click(function(){
                $('#modalIns').modal('show');
                $('.Ins-title').text('เพิ่มสาขา');
                $('.btn-ins-name').text('บันทึก');
                $('#id').val('');
                $('#name').val('');
                $('#formIns').find('small').remove();
            });

            /** Submit */
            $('#formIns').submit(function(e){
                e.preventDefault();
                $('#formIns').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('major.create')}}",
                    data: $('#formIns').serialize(),
                    dataType: "json",
                    success: function (response) {
                        $('#modalIns').modal('hide');
                        table.ajax.reload();
                        $('#id').val('');
                        $('#name').val('');
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

            /* edit */
            $(document).on('click','.edit',function(){
                $('#modalIns').modal('show');
                $('.Ins-title').text('แก้ไขสาขา');
                $('.btn-ins-name').text('อัพเดต');
                $('#id').val($(this).data('id'));
                $('#name').val($(this).data('name'));
            });

            /* delete */
            $(document).on('click','.delete',function(){
                $('#modalDel').modal('show');
                $('#dels_id').val($(this).data('id'));
            });

            /* submit delete */
            $('#formDel').submit(function(e){
                e.preventDefault();
                var id = $('#dels_id').val();
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    type: "DELETE",
                    url: "/major/delete/"+id,
                    data: {
                        id:id,
                        _token:token
                    },
                    success: function (data) {
                        $('#modalDel').modal('hide');
                        table.ajax.reload();
                    },error: function(errors) {
                        console.log(errors);
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
        .card-header {
            font-size: 16px;
            font-weight: 500;
        }
        .card-header button {
            font-size: 14px;
            font-weight: 300;
        }.pagination {
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
        table tbody tr td  a{
            margin: 0px 5px 0px 0px;
        }
    </style>
@endpush