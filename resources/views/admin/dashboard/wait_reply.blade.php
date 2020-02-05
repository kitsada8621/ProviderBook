@extends('admin.layout.app')
@section('title','หน้าแรก (ผู้จัดการ)')
@section('content')
<div class="container-fluid dashboard-content ">
        
        @include('admin.dashboard.pageheader')
       
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <h5 class="card-header">ข้อมูลคำร้องข้อยืมหนังสือ</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped" width="100%" cellspacing="0" id="myTables">
                                <thead>
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">ชื่อโครงงาน</th>
                                        <th class="border-0">ผู้ร้องขอยืม</th>
                                        <th class="border-0">วันที่ร้อง</th>
                                        <th class="border-0">กำหนดวันส่ง</th>
                                        <th class="border-0">สถานะ</th>
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
@include('admin.modal')
@endsection
@push('script')

    <script>
        
        $(document).ready(()=>{

            let table = $('#myTables').DataTable({
                processing:true,
                serverSide:true,
                bInfo:false,
                ajax:"{{route('admin.wait.home')}}",
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'p_name',name:'p_name'},
                    {data:'std_name',name:'std_name'},
                    {data:'br_date',name:'br_date'},
                    {data:'due_date',name:'due_date'},
                    {data:'status',name:'status'},
                    {data:'action',name:'action',orderable:false,searchable:false},
                ],columnDefs:[
                    {targets:[0,3,4,5,6],className:'text-center'}
                ]
            });

            $('.search-control').keyup(function(){
                table.search($('.search-control').val()).draw();
            });

            const modalConfirm = $('#modalConfirm');

            $(document).on('click','.borrow-confirm',function(){
                modalConfirm.modal('show');
                $('#id').val($(this).data('id'));
            });

            $('.yes-confirm-borrow').click(()=>{
                const token = "{{ csrf_token() }}";
                const id = $('#id').val();
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.yesconfirm')}}",
                    data: {id:id,_token:token},
                    dataType: "json",
                    success: function (data) {
                        $('#modalConfirm').modal('hide');
                        table.ajax.reload();
                    }
                });
            });
            
            $('.no-confirm-borrow').click(()=>{
                const token = "{{ csrf_token() }}";
                const id = $('#id').val();
                $.ajax({
                    type: "POST",
                    url: "/home/reject",
                    data: {id:id,_token:token},
                    dataType: "json",
                    success: function (data) {
                        modalConfirm.modal('hide');
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
        table thead tr {
            text-align: center;
        }
        table thead tr th {
            font-size: 13px;
            font-weight: 600 !important;
        }
        table tbody tr td {
            font-size: 14px; 
            font-weight: 300 !important;
        }
        table tbody tr td button{
            font-size: 12px !important;
            margin-right: 5px;
        }
        .card-header {
            font-size: 16px;
            font-weight: 500 !important;
        }
        .pagination {
            padding:10px 10px;
        }
        @media (max-width:1200px) {
            table tbody tr td button {
                font-size: 12px;
                margin: 0px 5px 5px 0px;
            }
        }    
    </style>
@endpush