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
                                <li class="breadcrumb-item"><a href="#" onclick="location.reload();" class="breadcrumb-link">คืนหนังสือ</a></li>
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
                            <table class="table table-striped table-borderless" id="myTables" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr class="border-0">
                                        <th class="border-0">#</th>
                                        <th class="border-0">ชื่อหนังสือ</th>
                                        <th class="border-0">ชื่อผู้ยืม</th>
                                        <th class="border-0">วันที่ยืม</th>
                                        <th class="border-0">กำหนดคืน</th>
                                        <th class="border-0">ค่าปรับ</th>
                                        <th class="border-0">คืนหนังสือ</th>
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
    @include('admin.pages.ReturnBooks.returnmodal')
@endsection
@push('script')
    <script>
        $(function(){

            /** Feth Data*/
            const table = $('#myTables').DataTable({
                processing: true,
                serverside: true,
                bInfo: false,
                ajax: '{{route('re.getBorrowing')}}',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'p_name',name:'p_name'},
                    {data:'std_name',name:'std_name'},
                    {data:'br_date',name:'br_date'},
                    {data:'due_date',name:'due_date'},
                    {data:'fine',name:'fine'},
                    {data:'action',name:'action',oderable:false,searchable:false}
                ],columnDefs: [
                    {
                        targets:[0,1,3,4,5,6],
                        className: 'text-center'
                    }
                ]
            });

            /** Search Control */
            $('.search-control').keyup(function(){
                table.search($(this).val()).draw();
            });

            /** Confirm Return books */
            $(document).on('click','.returns',function(){
                $('#modalReturn').modal('show');
                $('.closed').text('ยกเลิก');
                $('.confirm').show();
                document.getElementById('id').value= $(this).data('id');
                $('.student-name').text($(this).data('std_name'));
                $('.book-name').text($(this).data('p_name'));
                $('.borrow-date').text($(this).data('br_date'));
                $('.due-date').text($(this).data('due_date'));
                $('.borrow-fine').text($(this).data('fine'));
                $('#formReturn').find('small').remove();
            });

            /** form submit */
            $('#formReturn').submit((e)=>{
                e.preventDefault();
                var id = document.getElementById('id').value;
                var token = $("meta[name='csrf-token']").attr("content");
                $('#formReturn').find('small').remove();

                $.ajax({
                    type: "POST",
                    url: "{{route('re.confirm')}}",
                    data: {
                        id:id,
                        _token:token
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data.success == true) {
                            $('#modalReturn').modal('hide');
                            table.ajax.reload();
                        }else {
                            $('#modalReturn').modal('hide');
                            $('#modalFine').modal('show');
                            $('.fine-title').text('ชำระค่าปรับ');
                            $('.fine-message').text('ยืนยันการชำระค่าปรับ');
                            document.getElementById('fineid').value = data.br_id;
                            document.getElementById('fine_close').style.display="none";
                            document.getElementById('print_close').style.display="none";
                            document.getElementById('print_confirm').style.display="none";
                            document.getElementById('og_close').style.display="block";
                            document.getElementById('confirm_close').style.display="block";
                            document.getElementById('confirm_fine').style.display="block";
                        }
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

                document.getElementById('confirm_fine').addEventListener('click',()=>{
                    $('#modalFine').modal('show');
                    $('.fine-title').text('ใบเสร็จการปรับ');
                    $('.fine-message').text('ต้องการใบเสร็จการปรับหรือไม่  ?.');
                    document.getElementById('fine_close').style.display="block";
                    document.getElementById('print_close').style.display="block";
                    document.getElementById('print_confirm').style.display="block";
                    document.getElementById('og_close').style.display="none";
                    document.getElementById('confirm_close').style.display="none";
                    document.getElementById('confirm_fine').style.display="none";
                });

                document.getElementById('print_close').addEventListener('click',(e)=>{
                    e.preventDefault();
                    let id = document.getElementById('fineid').value;
                    const token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        type: "POST",
                        url: "{{route('re.confirm.printno')}}",
                        data: {
                            id:id,
                            _token:token
                        },
                        dataType: "json",
                        success: function (data) {
                            if(data.success == true) {
                                $('#modalFine').modal('hide');
                                table.ajax.reload();
                            }
                        }
                    });
                });

                document.getElementById('print_confirm').addEventListener('click',(e)=>{
                    e.preventDefault();
                    var id = document.getElementById('fineid').value;
                    const token = $("meta[name='csrf-token']").attr("content");
                    $('#modalFine').modal('hide');
                    location.href="/returns/receipt/"+id;
                });

                document.getElementById('fine_close').addEventListener('click',(e)=>{
                    e.preventDefault();
                    var id = document.getElementById('fineid').value;
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        type: "POST",
                        url: "{{route('re.confirm.printno')}}",
                        data: {
                            id:id,
                            _token:token
                        },
                        dataType: "json",
                        success: function (data) {
                            if(data.success == true) {
                                $('#modalFine').modal('hide');
                                table.ajax.reload();
                            }
                        }
                    });
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
        .pagination {
            padding: 10px 10px;
        }
        table thead tr th {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: gray !important;
        }
        table tbody tr td {
            font-size: 14px !important;
            font-weight: 300 !important;
        }
        table tbody tr td a{
            margin: 0px 5px 0px 0px;
        }
        .list-group-item {
            font-size: 13px; 
            font-weight: 500 !important;
        }
        .list-group-item:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5)
        }
        .list-group-item span {
            font-size: 13px;
            font-weight: 300 !important;
        }
    </style>
@endpush