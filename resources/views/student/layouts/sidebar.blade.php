<div class="nav-left-sidebar sidebar-liner  ">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg">
            <a class="d-xl-none d-lg-none" href="#"></a>
            <button class="navbar-toggler" type="button" id="side_toggle" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-layout-grid2-alt"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        เมนู
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('user/student*')) ? 'active' : '' }}" href="{{route('users.student.home')}}"><i class="fa-fw ti-home"></i>หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('user/borrow')) ? 'active' : '' }}" href="{{route('users.br.home')}}"><i class="fa-fw ti-write"></i>ยืมหนังสือ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('user/book')) ? 'active' : '' }}" href="{{route('users.b.home')}}"><i class="fa-fw ti-book"></i>หนังสือโครงงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('user/project') ? 'active' : '')}}" href="{{route('users.p.home')}}"><i class="fa-fw ti-layout-media-left-alt"></i>โครงงาน (Project)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('user/history*') ? 'active' : ''}} " href="/user/history"><i class="fa-fw ti-loop"></i>ประวัติการยืม</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user/setting*') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-12" aria-controls="submenu-12"><i class="fas fa-f fa-folder"></i>ข้อมูลส่วนตัว</a>
                        <div id="submenu-12" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('user/setting/resume') ? 'active' : '' }} " href="{{route('users.resume')}}">จัดการข้อมูลส่วนตัว</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('user/setting/password') ? 'active' : '' }} " href="/user/setting/password">จัดการรหัสผ่าน</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('student.logout')}}">ออกจากระบบ</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>