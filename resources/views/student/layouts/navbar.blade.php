<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="/">ยืม-คืนโครงงาน</a>
        <button class="navbar-toggler" type="button" id="nav_toggles" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-view-list"></i>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <li class="nav-item">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control search-control" type="text" placeholder="กรอกข้อมูลเพื่อค้นหา...">
                    </div>
                </li>
                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(empty(Auth::guard('students')->user()->image))
                        <img src="{{url('assets/images/avatar-1.jpg')}}" alt="" class="user-avatar-md rounded-circle">
                        @else
                        <img src="/uploads/{{Auth::guard('students')->user()->image}}" alt="" class="user-avatar-md rounded-circle">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info">
                            <h5 class="mb-0 text-white nav-user-name">{{Auth::guard('students')->user()->std_name}}</h5>
                        </div>
                        <a class="dropdown-item" href="{{route('users.resume')}}"><i class="fas fa-user mr-2"></i>ข้อมูลส่วนตัว</a>
                        <a class="dropdown-item" href="{{route('studentPasswordView')}}"><i class="fas fa-cog mr-2"></i>รหัสผ่าน</a>
                        <a class="dropdown-item" href="{{route('student.logout')}}"><i class="fas fa-power-off mr-2"></i>ออกจากระบบ</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>