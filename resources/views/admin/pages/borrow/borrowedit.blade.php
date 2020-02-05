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
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tables</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
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
                    <div class="card-body">
                        <button type="button" class="btn btn-primary float-right mb-2" onclick="location.href='/borrow'">กลับไปยังหน้าหลัก</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="myTables" width="100%" cellspacing="0">
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
@endsection
@push('script')
    <script>
        $(function(){
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
        });
    </script>
@endpush
@push('style')
    <style>
        .dataTables_length,
        .dataTables_filter {
            display: none;
        }
    </style>
@endpush