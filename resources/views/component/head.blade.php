<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header bg-white-5">
        <div class="text-center">
            <a class="font-w600 text-dual" href="{{ route('dashboard') }}">
                <span class="smini-visible">
                    <i class="fa fa-circle-notch text-primary"></i>
                </span>
                <span class="smini-hide font-size-h5 tracking-wider">
                    PO
                </span>
            </a>
        </div>
        <div>
            <div class="dropdown d-inline-block ml-2">
                <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-fw fa-times"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link @if(collect(request()->segments())->last() == 'dashboard') {{ 'active' }} @endif" href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon fas fa-home"></i>
                        <span class="nav-main-link-name">หน้าหลัก</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header id="page-header">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown d-inline-block ml-2">
                @php
                    if (Storage::disk('public')->exists('assets/avatar/'.Auth::user()->avatar) && Auth::user()->avatar != null) {
                        $avatar = url(Storage::url('assets/avatar/'.Auth::user()->avatar));
                    }else {
                        $avatar = url(Storage::url('assets/static/image/avatar_null.jpg'));
                    }
                @endphp
                <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded" src="{{ $avatar }}" alt="Image Profile" style="width: 21px;">
                    <span class="d-none d-sm-inline-block ml-1">{{ Auth::user()->fname }}</span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0" aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-primary-dark rounded-top">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ $avatar }}" alt="Image Profile">
                        <p class="mt-2 mb-0 text-white font-w500">{{ Auth::user()->fname }}  {{ Auth::user()->lname }}</p>
                        <p class="mb-0 text-white-50 font-size-sm">Web Developer</p>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                            <span class="font-size-sm font-w500"><i class="fas fa-user-cog mr-1"></i>ตั้งค่าบัญชี</span>
                        </a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('logout') }}">
                            <span class="font-size-sm font-w500"><i class="fas fa-sign-out-alt mr-1"></i>ออกจากระบบ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="page-header-loader" class="overlay-header bg-white">
        <div class="content-header">
            <div class="w-100 text-center">
                <span class="text-info"><i class="fa fa-fw fa-circle-notch fa-spin"></i> | โหลดรอซักครู่กำลังโหลดข้อมูล</span>
            </div>
        </div>
    </div>
    
</header>