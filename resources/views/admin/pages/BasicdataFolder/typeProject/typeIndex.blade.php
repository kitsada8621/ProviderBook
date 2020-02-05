@extends('admin.layout.app')
@section('title',$header)
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
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">ประเภทโครงงาน</a></li>
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
                        <button class="btn btn-outline-light btn-sm btn-add" id="btnAdd" type="button">เพิ่ม ประเภทโครงงาน</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-0">
                            <table class="table table-striped table-borderless" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
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
    
    <!-- Modal -->
    <div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ins-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="formIns">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="id" readonly>
                    <div class="form-group">
                        <label for="name">ประเภทโครงงาน</label>
                        <input id="name" class="form-control" type="text" name="name">
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
                <div class="modal-body">
                    <input type="hidden" id="delid" readonly>
                    <div class="text-center">
                        <p>ต้องการลบข้อมูล ใช่หรือไม่ ?.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-danger btn-delete">ลบข้อมูล</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(document).ready(()=>{
            /** show data */
            let table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo :false,
                ajax: "{{route('getTypeProject')}}",
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'name',name:'name'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ],columnDefs:[
                    {targets:[0,1,2],className:'text-center'}
                ]
            });

            $('#btnAdd').click(()=>{
                $('#modalIns').modal('show');
                $('.ins-title').text('เพิ่มข้อมูล');
                $('.btn-ins-name').text('บันทึก');
                $('#formIns').find('small').remove(); 
                ClearForm();
            });

            let ClearForm = ()=>{
                $('#id').val('');
                $('#name').val('');
            }

            $(document).on('click','.edit',function(){
                $('#modalIns').modal('show');
                $('.ins-title').text('แก้ไขข้อมูล');
                $('.btn-ins-name').text('อัพเดต');
                $('#id').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#formIns').find('small').remove();
            });

            $('#formIns').submit((e)=>{
                e.preventDefault();
                $('#formIns').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('typePro.create')}}",
                    data: $('#formIns').serialize(),
                    dataType: "json",
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

            $(document).on('click','.delete',function(){
                $('#modalDel').modal('show');
                $('#delid').val($(this).data('id'));
            });

            $('.btn-delete').click((e)=>{
                e.preventDefault();
                var id = $('#delid').val();
                $.ajax({
                    type: "DELETE",
                    url: "/type/project/delete/"+id,
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        $('#modalDel').modal('hide');
                        table.ajax.reload();
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
        }.btn-add {
            font-size: 14px; font-weight: 300;
        }
        .dataTables_length,
        .dataTables_filter {
            display: none;
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
        table tbody tr td a {
            margin: 0px 5px 0px 0px;
        }
        @media (max-width:360px) {
            table tbody tr td a {
                margin: 0px 5px 5px 0px;
            }
        }
    </style>
@endpush