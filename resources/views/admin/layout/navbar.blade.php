<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="/">ยืม-คืนโครงงาน</a>
        <a href="#" class="navbar-toggler" id="nav-toggle" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-view-list"></i>
            {{-- <img src="/uploads/{{Auth::user()->name}}" width="60" height="60" class="navbar-toggler-icon rounded-circle" alt="profile"> --}}
        </a>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <li class="nav-item">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control search-control" type="text" placeholder="กรอกข้อมูลเพื่อค้นหา...">
                    </div>
                </li>
                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(empty(Auth::user()->image))
                            <img src="{{url('assets/images/avatar-1.jpg')}}" alt="" class="user-avatar-md rounded-circle">
                        @else
                            <img src="/uploads/{{Auth::user()->image}}" alt="" class="user-avatar-md rounded-circle">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info">
                            <h5 class="mb-0 text-white nav-user-name">{{Auth::user()->name}}</h5>
                            {{-- <span class="status"></span><span class="ml-2"></span> --}}
                        </div>
                        <a class="dropdown-item" href="/admin/profile"><i class="fas fa-user mr-2"></i>ข้อมูลส่วนตัว</a>
                        <a class="dropdown-item" href="/admin/password"><i class="fas fa-cog mr-2"></i>ตั้งค่ารหัสผ่าน</a>
                        <a class="dropdown-item" href="{{route('logout')}}"><i class="fas fa-power-off mr-2"></i>ออกจากระบบ</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>