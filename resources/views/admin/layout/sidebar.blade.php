<div class="nav-left-sidebar sidebar-liner">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-sm d-lg-none" href="#">เมนู</a>
            <button class="navbar-toggler" id="side-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class=" ti-layout-grid2-alt"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        เมนู
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }} {{ (request()->is('home*')) ? 'active' : '' }}" href="/"><i class="fas fa-fw fa-home"></i>หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('borrow')) ? 'active' : '' }}" href="/borrow"><i class="fas fa-fw fa-archive"></i>ยืมหนังสือ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('returns')) ? 'active' : '' }}" href="/returns"><i class="fas fa-fw fa-share-square"></i>คืนหนังสือ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('history/borrow')) ? 'active' : '' }}" href="{{route('his.br.index')}}"><i class="fas fa-fw fa-history"></i>ประวัติการยืม</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('book*')) ? 'active' : '' }}" href="{{route('admin.book')}}"><i class="fas fa-fw fa-server  "></i>หนังสือโครงงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('projects')) ? 'active' : '' }}" href="{{route('admin.p.home')}}"><i class="fas fa-fw fa-window-restore"></i>โครงงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('renew')) ? 'active' : '' }}" href="/renew"><i class="fas fa-fw fa-file-archive"></i>ต่ออายุการยืม</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('major')) ? 'active' : '' }} {{ (request()->is('book/type')) ? 'active' : '' }} {{ (request()->is('type/project')) ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="fas fa-fw fa-user-secret"></i>จัดการข้อมูลทั่วไป</a>
                        <div id="submenu-9" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('major')) ? 'active' : '' }}" href="{{route('major')}}">สาขาวิชา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('book/type')) ? 'active' : '' }}" href="/book/type">ประเภทหนังสือ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('type/project')) ? 'active' : '' }}" href="/type/project">ประเภทโครงงาน</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admins')) ? 'active' : '' }} {{ (request()->is('std')) ? 'active' : '' }} {{ (request()->is('teacher')) ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-10" aria-controls="submenu-10"><i class="fas fa-f fa-address-book"></i>จัดการข้อมูลบุคคล</a>
                        <div id="submenu-10" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admins')) ? 'active' : '' }}" href="{{route('admins.home')}}">จัดการข้อมูลเจ้าหน้าที่</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('std')) ? 'active' : '' }}" href="{{route('std.home')}}">นักศึกษา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('teacher')) ? 'active' : '' }}" href="/teacher">อาจารย์</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-12" aria-controls="submenu-12"><i class="fas fa-f fa-address-card"></i>ข้อมูลส่วนตัว</a>
                        <div id="submenu-12" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">จัดการข้อมูลส่วนตัว</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">จัดการรหัสผ่าน</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">ออกจากระบบ</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </nav>
    </div>
</div>