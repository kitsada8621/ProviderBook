@extends('admin.layout.app')
@section('title','เพิ่มข้อมูลด้วยไฟล์ Excel')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body" style="height:450px;">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                            <form action="/std/import" enctype="multipart/form-data" method="POST">
                                @csrf
                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                        {{ session()->get('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif 
                                <div class="form-group mt-2">
                                    <label for="file">เพิ่มข้อมูลด้วยไฟล์ Excel File</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                    @error('file')
                                        <strong class="small text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="location='/std'" class="btn btn-light">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
    </script>
@endpush
@push('style')
    <style>
    </style>
@endpush