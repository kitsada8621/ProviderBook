@extends('student.layouts.app')
@section('title','ยืมหนังสือโครงงาน')
@section('content')
    <div class="container-fluid dashboard-content">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">ยืมหนังสือ</h2>
                    <p class="pageheader-text">ยืมหนังสือ</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/user/student/home" class="breadcrumb-link">หน้าหลัก</a></li>
                                <li class="breadcrumb-item"><a href="/user/borrow" class="breadcrumb-link">ยืมหนังสือ</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <span class="card-header">
                        ข้อมูลหนังสือที่พร้อมยืม
                    </span>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table myTables" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">รหัสหนังสือ</th>
                                        <th class="border-0">ชื่อหนังสือ</th>
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

    @include('student.pages.borrow.borrowPop')
@endsection
@push('script')
    <script>
        $(document).ready(()=>{

            let table = $('.myTables').DataTable({
                processing: true,
                serverSide: true,
                bInfo: false,
                ajax: '/user/borrow',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'b_id',name:'b_id',orderable:false},
                    {data:'p_name',name:'p_name',orderable:false},
                    {data:'type',name:'type',orderable:false},
                    {data:'category',name:'category',orderable:false},
                    {data:'status',name:'status',orderable:false},
                    {data:'action',name:'action',orderable:false,searchable:false},
                ],columnDefs: [
                    {targets:[0,1,3,4,5,6],className:'text-center'}
                ]
            });

            $('.search-control').keyup(()=>{
                table.search($('.search-control').val()).draw();
            });

            let modalBorrow = $('#modalBorrowing');
            
            $(document).on('click','#btnBorrow',function(){
                modalBorrow.modal('show');
                $('#b_id').val($(this).data('b_id'));
                $('#due_date').val('');
                $('#formBorrow').find('small').remove();
            });

            $('#formBorrow').submit((e)=>{
                e.preventDefault();
                $('#formBorrow').find('small').remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('users.br.create')}}",
                    data: $('#formBorrow').serialize(),
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true){
                            modalBorrow.modal('hide');
                            location.href="/user/student/home";
                        }else {
                            $('.err-message').show();
                            $('.err-message-detail').text(data.message);
                        }
                    },error: function (err) {
                        var res = err.responseJSON;
                        if (jQuery.isEmptyObject(res) ==false ) {
                            jQuery.each(res.errors,function(key,value){
                                jQuery('#'+key)
                                    .closest('.form-group').append('<small id="helpId" class="text-danger">'+value+'</small>');
                            });
                        }
                    }
                });
            });

            $('.err-close').click(function(){
                $('.err-message').hide();
            });

            /*Details*
             * 
             */
            $(document).on('click','.detail',function(){
                $('#modal_detail').modal('show');
                $('.b-id').text($(this).data('b_id'));
                $('.p-name').text($(this).data('p_name'));
                $('.type').text($(this).data('type'));
                $('.category').text($(this).data('category'));
                $('.status').text($(this).data('status'));
                $('.description-text').text($(this).data('description'));
            });

            /*end Details*
             * 
             */

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
            border: none !important;
        }
        table tbody tr td {
            font-size: 14px; 
            font-weight: 300 !important;
        }
        table tbody tr td button {
            display: inline-block;
            margin: 2px 5px;
        }
        .dataTables_length,
        .dataTables_filter{
            display: none;
        }.pagination {
            padding: 10px;
        }
        .err-message {
            margin: 10px 0px;
            background-color: #e9ecef;
            padding: 10px 15px 10px 20px;
            border-left: 5px solid red;
        }
        .page-item.active .page-link {
            transition: .3s ease-in-out;
        }
        .page-item.active .page-link:hover {
            background-color: #2C40F8;
            border-color: #2C40F8;
            color: white;
        }
        .list-group-item {
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
        .description-title {
            font-size: 14px;
            font-weight: 400;
        }
        .description-text {
            font-size: 14px;
            font-weight: 300;
            padding-bottom: 30px;
            text-indent: 2rem;
        }
    </style>
@endpush