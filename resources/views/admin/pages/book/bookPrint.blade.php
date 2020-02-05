@extends('admin.layout.app')
@section('title','หนังสือ พิมพ์หนังสือ')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">พิมพ์หนังสือ</h2>
                    <p class="pageheader-text">พิมพ์หนังสือ</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" onclick="location.href='/';" class="breadcrumb-link">หน้าแรก</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.href='/';" class="breadcrumb-link">หนังสือ</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">พิมพ์หนังสือ</a></li>
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
                        <span>พิมพ์หนังสือ</span>
                        <a href="/book" class="btn btn-outline-light btn-sm"><i class="far fa-arrow-alt-circle-left"></i>กลับไปหน้าหลัก</a>
                    </div>
                    <div class="card-body p-0">
                        <form action="/book/allPrint" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped" id="myTables" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="border-0 text-center">
                                            <th class="border-0">#</th>
                                            <th class="border-0">   
                                                <div class="form-check form-check-inline">
                                                    <input id="check_all" class="form-check-input" type="checkbox" name="check_all">
                                                    <label for="check_all" class="form-check-label">ทั้งหมด</label>
                                                </div>                                                                         
                                            </th>
                                            <th class="border-0">รหัสหนังสือ</th>
                                            <th class="border-0">ชื่อหนังสือ</th>
                                            <th class="border-0">ประเภทหนังสือ</th>
                                            <th class="border-0">พิมพ์</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 print-form">
                                <button class="btn btn-primary btn-xs btn-print-all" type="submit"><i class="fas fa-print"></i>พิมพ์ Barcode</button>
                            </div>
                        </form>
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
                ajax: '/book/print',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'checking',name:'checking',orderable:false,searchable:false},
                    {data:'b_id',name:'b_id'},
                    {data:'p_name',name:'p_name'},
                    {data:'type',name:'type'},
                    {data:'printed',name:'printed',orderable:false,searchable:false}
                ],
                columnDefs: [
                    {
                        targets:[0,1,2,4,5],
                        className: 'text-center'
                    }
                ]
            });

            /** Search */
            $('.search-control').keyup(function(){
                    table.search($('.search-control').val()).draw();
            });

            $('#check_all').click(function(event) {
                if(this.checked) {
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                }
                else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $(document).on('click','#printing',function(){
                var id = $(this).data('id');
                location.href="/book/print/self/"+id;
            });
            
        });
    </script>
@endpush
@push('style')
    <style>
        table thead tr th {
            font-size: 13px;
            font-weight: 600 !important;
        }
        table tbody tr td {
            font-size: 14px;
            font-weight: 300 !important;
        }
        table tbody tr td a{
            margin: 0px 5px 0px 0px;
        }
        .card-header span{
            font-size: 16px;
            font-weight: 500;
        }
        .card-header a {
            font-size: 14px;
            font-weight: 400 !important;
        }
        .card-header a i {
            font-size: 12px;
            margin-right: 5px;
        }
        .dataTables_length,
        .dataTables_filter {
            display: none;
        }
        .pagination {
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .print-form button {
            font-size: 13px;
            font-weight: 400 !important;
        }
        .print-form button i{
            font-size: 12px;
            margin-right: 5px;
        }

    </style>
@endpush