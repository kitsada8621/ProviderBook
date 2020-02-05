@extends('admin.layout.app')
@section('title','หน้าแรก (ผู้จัดการ)')
@section('content')
<div class="container-fluid dashboard-content ">
        
    @include('admin.dashboard.pageheader')
   
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">ข้อมูลการยืมที่อนุมัติ</h5>
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
                ajax:"{{route('admin.comple.home')}}",
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

            $(document).on('click','.detils',function(){
                $('#modaldetails').modal('show');
                $('.b-id').text($(this).data('b_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.type').text($(this).data('type'));
                $('.major').text($(this).data('major'));
                $('.std-name').text($(this).data('std_name'));
                $('.br-date').text($(this).data('br_date'));
                $('.due-date').text($(this).data('due_date'));
                $('.fine').text($(this).data('fine'));
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
        .card-header {
            font-size: 16px;
            font-weight: 500 !important;
        }
        .pagination {
            padding:10px 10px;
        }
        .list-group-item:nth-of-type(odd) {
            background-color: rgba(230,230, 242, .5);
        }
        .list-group-item strong {
            font-size: 13px;
            font-weight: 500 !important;
            margin-right: 5px;
            padding-left: 10px;
        }
        .list-group-item span {
            font-size: 13px;
            font-weight: 300 !important;
            padding-left: 5px;
        }
        .list-group-item {
            padding: 10px 15px;
            border: none;
        }
        .modal-header {
            padding: 15px 20px !important; 
        }
    </style>
@endpush