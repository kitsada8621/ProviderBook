@extends('student.layouts.app')
@section('title','หน้าหลัก (นักศึกษา)')
@section('content')
    <div class="container-fluid dashboard-content ">
       @include('student.dashboard.pageheader')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <span class="card-header">ข้อมูลการยืมของคุณ</span>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" width="100%" cellspacing="0" id="myTables">
                                <thead>
                                    <tr class="text-center border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">ชื่อโครงงาน</th>
                                        <th class="border-0">ผู้ยืม</th>
                                        <th class="border-0">วันที่ยืม</th>
                                        <th class="border-0">กำหนดคืน</th>
                                        <th class="border-0">สถานะ</th>
                                        <th class="border-0">จัดการ</th>
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
    @include('student.homemodal')
@endsection
@push('script')
    <script>
        $(document).ready(()=>{

            let table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: '/user/dashboard/getbr',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'p_name',name:'p_name',orderable:false},
                    {data:'std_name',name:'std_name',orderable:false},
                    {data:'br_date',name:'br_date',orderable:false},
                    {data:'due_date',name:'due_date',orderable:false},
                    {data:'status',name:'status',orderable:false},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ],columnDefs: [
                    {
                        targets: [0,3,4,5,6],
                        className: 'text-center'
                    },{
                        targets:[1,2],
                        className: 'pl-3'
                    }
                ]
            });

            $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
            });

            $(document).on('click','.edit',function(){
                $('#modalBorrow').modal('show');
                $('#br_id').val($(this).data('br_id'));
                $('#b_id').val($(this).data('b_id'));
                $('#p_name').val($(this).data('p_name'));
                $('#due_date').val($(this).data('due_date'));
                document.getElementById('br_id').style.display="none";
                $('#formBorrow').find('small').remove();
                $('.err_book').hide();
                $('.err_book').text('');
            });

            $('#formBorrow').submit((e)=>{
                e.preventDefault();
                $('#formBorrow').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('users.br.edit')}}",
                    data: $('#formBorrow').serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#modalBorrow').modal('hide');
                            table.ajax.reload();
                        }else {
                            $('.err_book').show();
                            $('.err_book').text(data.message);
                        }
                    },error: function (err) {
                        var res = err.responseJSON;
                        if (jQuery.isEmptyObject(res) ==false ) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key).closest('.form-group').append('<small id="helpId" class="text-danger">'+value+'</small>');
                            });
                        }
                    }
                });
            });

            $(document).on('click','.delete',function(){
                $('#modaldel').modal('show');
                $('#delid').val($(this).data('br_id'));
                document.getElementById('delid').style.display="none";
            });

            $('.btn-remove').click(()=>{
                const id = $('#delid').val();
                $.ajax({
                    type: "delete",
                    url: "/user/borrow/delete/"+id,
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#modaldel').modal('hide');
                            table.ajax.reload();
                        }
                    }
                });
            });

            /**
            Details
             * 
             */
            $(document).on('click','.detail',function(){
                $('#modal_detail').modal('show');
                $('.b-id').text($(this).data('b_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.std-id').text($(this).data('std_id'));
                $('.std-name').text($(this).data('std_name'));
                $('.major').text($(this).data('major'));
                $('.br-date').text($(this).data('br_date'));
                $('.due-date').text($(this).data('due_date'));
                $('.fine').text($(this).data('fine'));
                $('.status').text($(this).data('status'));
            });
            /**
            End Details
             * 
             */

            $('#b_id').keyup(()=>{
                const id = $('#b_id').val();
                $.ajax({
                    type: "get",
                    url: "/get/books/id",
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            document.getElementById('p_name').value = data.p_name;
                        }else {
                            document.getElementById('p_name').value = "";
                        }
                    }
                });
            });

            $('#p_name').keyup(()=>{
                const name = $('#p_name').val();
                $.ajax({
                    type: "get",
                    url: "/get/books/names",
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

        });
    </script>
@endpush
@push('style')
    <style>
        .card-header {
            font-size: 16px;
            font-weight: 500;
        }
        table thead tr th {
            font-size: 13px;
            font-weight: 600 !important;
            border: none !important;
        } 
        table {
            border-top: none !important;
        } 
        table tbody tr td {
            font-size: 14px; 
            font-weight: 300 !important;
        }
        table tbody tr td a {
            display: inline-block;
            margin: 3px 5px;
        }
        .btn-details {
            background-color: #23CF4A;
            padding: 5px 9px;
            border-radius: 2px;
            font-size: 13px;
            transition: .3s ease-in-out;
            color: white;
        }
        .btn-details:hover {
            background-color: #00A525;
            color: white;
        }
        .btn-edit {
            background-color: #f3b600;
            padding: 5px 9px;
            border-radius: 2px;
            font-size: 13px;
            transition: .3s ease-in-out;
            color: white;
        }
        .btn-edit:hover {
            background-color: #BF8F01;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            padding: 5px 9px;
            border-radius: 2px;
            font-size: 13px;
            transition: .3s ease-in-out;
            color: white;
        }
        .btn-delete:hover {
            background-color: #B60414;
            color: white;
        }
        .dataTables_length,
        .dataTables_filter{
            display: none;
        }.pagination {
            padding: 10px;
        }
        .page-item.active .page-link {
            transition: .3s ease-in-out;
        }
        .page-item.active .page-link:hover {
            background-color: #2C40F8;
            border-color: #2C40F8;
            color: white;
        }
        .err_book {
            font-size: 12px;
            font-weight: 500;
            color: #B60414;
            padding-left: 5px;
        }
    </style>
@endpush