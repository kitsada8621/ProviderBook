@extends('student.layouts.app')
@section('title','ประวัติการยืม')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">ประวัติการยืมหนังสือของคุณ</h2>
                    <p class="pageheader-text">ประวัติการยืมหนังสือของคุณ</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/user/student/home" class="breadcrumb-link">หน้าหลัก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">ประวัติการยืม</a></li>
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
                        ข้อมูลประวัติการยืม
                        <button type="button" onclick="location.href='/user/borrow';" class="btn btn-outline-light btn-sm"><i class="ti-plus mr-1"></i>ยืมหนังสือ</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" width="100%" cellspacing="0" id="myTables">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">ผู้ยืม</th>
                                        <th class="border-0">ชื่อหนังสือ</th>
                                        <th class="border-0">วันที่ยืม</th>
                                        <th class="border-0">กำหนดคืน</th>
                                        <th class="border-0">วันที่คืน</th>
                                        <th class="border-0">รายละเอียด</th>
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
    
    <!-- Modal Detail -->
    <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">รายละเอียด</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ti-close"></i></span>
                        </button>
                </div>
                <div class="modal-body p-0">
                    <ul class="list-group">
                        <li class="list-group-item">รหัสหนังสือ&nbsp;:&nbsp;<span class="b-id"></span></li>
                        <li class="list-group-item">ชื่อหนังสือ&nbsp;:&nbsp;<span class="p-name"></span></li>
                        <li class="list-group-item">รหัสผู้ยืม&nbsp;:&nbsp;<span class="std-id"></span></li>
                        <li class="list-group-item">ชื่อผู้ยืม&nbsp;:&nbsp;<span class="std-name"></span></li>
                        <li class="list-group-item">สาขาของผู้ยืม&nbsp;:&nbsp;<span class="major"></span></li>
                        <li class="list-group-item">วันที่ยืม&nbsp;:&nbsp;<span class="br-date"></span></li>
                        <li class="list-group-item">กำหนดคืน&nbsp;:&nbsp;<span class="due-date"></span></li>
                        <li class="list-group-item">วันที่คืน&nbsp;:&nbsp;<span class="returning"></span></li>
                        <li class="list-group-item">ค่าปรับ&nbsp;:&nbsp;<span class="fine"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .card-header button {
            font-size: 14px;
            font-weight: 300;
        }
        .card-header button i{
            font-size: 12px;
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
        } table thead tr th {
            font-size: 13px;
            font-weight: 600 !important;
        } table tbody tr td {
            font-size: 14px;
            font-weight: 300 !important;
        } .modal-header {
            font-size: 16px;
            font-weight: 500 !important;
        } .modal-header button {
            font-size: 14px;
        } .list-group-item {
            font-size: 14px;
            font-weight: 500;
        } .list-group-item:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        } .list-group-item span {
            font-size: 14px;
            font-weight: 300;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(()=>{

            /** DataTables **/
            let table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: '/user/history',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'std_name',name:'std_name',orderable:false},
                    {data:'p_name',name:'p_name',orderable:false},
                    {data:'br_date',name:'br_date',orderable:false},
                    {data:'due_date',name:'due_date',orderable:false},
                    {data:'returning',name:'returning',orderable:false},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ],columnDefs :[
                    {
                        targets:[0,1,2,3,4,5,6],
                        className:'text-center'
                    }
                ]
            });
            /** End DataTables **/

            /** Searching **/
            $('.search-control').keyup(()=>{
                table.search($('.search-control').val()).draw();
            });
            /** End Searching **/

            /** Detail **/
            $(document).on('click','.details',function(){
                $('#modal_detail').modal('show');
                $('.b-id').text($(this).data('b_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.std-id').text($(this).data('std_id'));
                $('.std-name').text($(this).data('std_name'));
                $('.major').text($(this).data('major'));
                $('.br-date').text($(this).data('br_date'));
                $('.due-date').text($(this).data('due_date'));
                $('.returning').text($(this).data('returning'));
                $('.fine').text($(this).data('fine'));
            });
            /** End Detail **/

        });
    </script>
@endpush