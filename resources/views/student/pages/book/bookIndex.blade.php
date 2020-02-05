@extends('student.layouts.app')
@section('title','หนังสือ')
@section('content')
        
    <div class="container-fluid dashboard-content">
            
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">จัดการข้อมูลหนังสือ</h2>
                    <p class="pageheader-text">จัดการข้อมูลหนังสือ</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/user/student/home" class="breadcrumb-link">หน้าหลัก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">หนังสือ (Books)</a></li>
                                <li class="ml-2"><a href="#" class="badge badge-warning" style="font-size:12px;font-weight:500;color:wheat">หนังสือของฉัน</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <span class="card-header">ข้อมูลโครงงาน</span>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped myTables" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสหนังสือ</th>
                                        <th class="border-0">ชื่อหนังสือโครงงาน</th>
                                        <th class="border-0">ประเภทหนังสือ</th>
                                        <th class="border-0">ประเภทโครงงาน</th>
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
    
    <!-- Modal details -->
    <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดหนังสือ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body p-0">
                    <ul class="list-group">
                        <li class="list-group-item lgi">รหัสหนังสือ&nbsp;:&nbsp;<span class="b-id"></span></li>
                        <li class="list-group-item lgi">ชื่อหนังสือ&nbsp;:&nbsp;<span class="p-name"></span></li>
                        <li class="list-group-item lgi">ประเภทหนังสือ&nbsp;:&nbsp;<span class="type"></span></li>
                        <li class="list-group-item lgi">ประเภทโครงงาน&nbsp;:&nbsp;<span class="p-type"></span></li>
                        <li class="list-group-item lgi">สถานะ&nbsp;:&nbsp;<span class="status"></span></li>
                        <li class="list-group-item lgi">ผู้จัดทำ&nbsp;:&nbsp;<span class="std-name"></span></li>
                        <li class="list-group-item lgi">ที่ปรึกษา&nbsp;:&nbsp;<span class="t-name"></span></li>
                        <li class="list-group-item">
                            <div class="text-center">
                                <h5 class="description-title">รายละเอียดหนังสือ (โดยย่อ)</h5>
                            </div>
                            <p class="description-text"></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('script')
    <script>
        $(document).ready(()=>{


            /* show data */
            let table = $('.myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: '{{route('users.b.home')}}',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'b_id',name:'b_id',orderable: false},
                    {data:'p_name',name:'p_name',orderable: false},
                    {data:'type',name:'type',orderable: false},
                    {data:'category',name:'category',orderable: false},
                    {data:'status',name:'status',orderable: false},
                    {data:'action',name:'action',orderable: false,searchable: false}
                ],columnDefs:[
                    {targets:[0,1,3,4,5,6],className:'text-center'}
                ]
            });

            /* Search */
            $('.search-control').keyup(()=>{
                table.search($('.search-control').val()).draw();
            });

            /* details */
            $(document).on('click','.detail',function(){
                $('#modal_detail').modal('show');
                $('.b-id').text($(this).data('b_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.type').text($(this).data('type'));
                $('.p-type').text($(this).data('category'));
                $('.status').text($(this).data('status'));
                $('.std-name').text($(this).data('std_name'));
                $('.t-name').text($(this).data('t_name'));
                $('.description-text').text($(this).data('description'));
            });
            /* end details */

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
        .list-group-item {
            border: none;
            font-size: 14px;
            font-weight: 400; 
        }
        .list-group-item span {
            font-size: 14px;
            font-weight: 300;
        }
        .list-group-item:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        }
        .description-text {
            font-size: 14px;
            font-weight: 300;
            text-indent: 2rem;
            padding-bottom: 30px;
        }.description-title{
            font-size: 14px;
            font-weight: 400;
        }
    </style>
@endpush