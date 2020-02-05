@extends('admin.layout.app')
@section('title',$header)
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$header}}</h5>
                        <form class="container-fluid mt-3">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="">รหัสผู้ดูแล</label>
                                        <input id="" class="form-control" type="text" name="">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="">ชื่อ-สกุล</label>
                                        <input id="" class="form-control" type="text" name="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="">อีเมลล์</label>
                                        <input id="" class="form-control" type="text" name="">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="">ชื่อผู้ใช้งาน</label>
                                        <input id="" class="form-control" type="text" name="">
                                    </div>
                                </div>
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

            $('.search-control').hide();

        });
    </script>
@endpush
@push('style')
    <style>
        .card {
            max-height: 700px;
            height: 100%;
        }
    </style>
@endpush