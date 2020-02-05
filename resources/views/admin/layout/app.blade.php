<!doctype html>
<html lang="en">
 
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link href="{{asset('assets/vendor/fonts/circular-std/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/libs/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/themify-icons/themify-icons.css')}}">
    <!-- Datables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Prompt:100,100i,200,200i,300,400,500,600,700&display=swap" rel="stylesheet">
    <style>
        html {
            overflow: scroll;
            overflow-x: hidden;
        }
        ::-webkit-scrollbar {
            width: 0px;
            height: 7px;
            background: #fff;
        }
        ::-webkit-scrollbar-thumb {
            background: #5969ff;
            border-radius: 10px;
        }
    </style>
    @stack('style')
    <title>@yield('title')</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        @include('admin.layout.navbar')
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        @include('admin.layout.sidebar')
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            @yield('content')
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            @include('admin.layout.footer')
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    {{-- <script src="{{asset('assets/vendor/jquery/jquery-3.3.1.min.js')}}"></script> --}}
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Datables -->
    <script src="{{asset('js/dataTables.min.js')}}"></script>    
    <!-- bootstap bundle js -->
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
    <!-- slimscroll js -->
    <!-- main js -->
    <script src="{{asset('assets/libs/js/main-js.js')}}"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        
            document.getElementById('nav-toggle').addEventListener('click',()=>{

                if($(this).find('#nav-toggle i').hasClass('ti-view-list')) {
                    $(this).find('#nav-toggle i').removeClass('ti-view-list').addClass('ti-close');
                }else {
                    $(this).find('#nav-toggle i').removeClass('ti-close').addClass('ti-view-list');
                }
            });

            document.getElementById('side-toggler').addEventListener('click',()=>{
                if($(this).find('#side-toggler i').hasClass('ti-layout-grid2-alt')) {  
                    $(this).find('#side-toggler i').removeClass('ti-layout-grid2-alt').addClass('ti-close');
                }else {
                    $(this).find('#side-toggler i').removeClass('ti-close').addClass('ti-layout-grid2-alt');
                }
            });
        });
    </script>
    @stack('script')
</body>
 
</html>