@extends('admin.layout.app')
@section('title',$header)
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{{$header}}</h2>
                    <p class="pageheader-text">{{$header}}</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">ประวัติการยืม</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{{$title}}</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">ชื่อหนังสือ</th>
                                        <th class="border-0">ชื่อผู้ยืม</th>
                                        <th class="border-0">วันที่ยืม</th>
                                        <th class="border-0">กำหนดคืน</th>
                                        <th class="border-0">วันที่คืน</th>
                                        <th class="border-0">ค่าปรับ</th>
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


@endsection
@push('script')
    <script>
        $(document).ready(()=>{
        

            let table = $('#myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: "{{route('his.br.get')}}",
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'p_name',name:'p_name'},
                    {data:'std_name',name:'std_name'},
                    {data:'br_date',name:'br_date'},
                    {data:'due_date',name:'due_date'},
                    {data:'returning',name:'returning'},
                    {data:'fine',name:'fine'}
                ],
                columnDefs:[
                    {
                        targets:[0,3,4,5,6],
                        className: "text-center"
                    }
                ]
            });

            $('.search-control').keyup(()=>{
                table.search($('.search-control').val()).draw();
            })

        });
    </script>
@endpush
@push('style')
    <style>
        .dataTables_length,
        .dataTables_filter {
            display: none;
        }
        table thead tr th {
            font-size: 13px; 
            font-weight: 500 !important;
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