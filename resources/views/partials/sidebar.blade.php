<aside class="left-sidebar" style="background-color: rgb(31,54,46); border-color:black">
    <!-- Sidebar scroll-->
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="javascript:void(0)" class="text-wrap text-center p-2">
            <span class="h6 fw-bolder text-white">{{ config('app.name') }}</span>
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            @if (Auth::user()->role === 'Admin')
                <li class="sidebar-item">
                    <a class="sidebar-link{{ Request::is('beranda') ? 'active' : '' }}" href="beranda">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('data-guru') ? 'active' : '' }}" href="data-guru">
                        <span>
                            <i class="ti ti-chalkboard"></i>
                        </span>
                        <span class="hide-menu">Data Guru</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" {{ Request::is('data-siswa') ? 'active' : '' }} href="data-siswa">
                        <span>
                            <i class="ti ti-school"></i>
                        </span>
                        <span class="hide-menu">Data Siswa</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('data-kelas') ? 'active' : '' }}" href="data-kelas">
                        <span>
                            <i class="ti ti-building"></i>
                        </span>
                        <span class="hide-menu">Data Kelas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('data-user') ? 'active' : '' }}" href="data-user">
                        <span>
                            <i class="ti ti-user-check"></i>
                        </span>
                        <span class="hide-menu">Data User</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('data-absensi' ? 'active' : '') }}" href="data-absensi">
                        <span>
                            <i class="ti ti-table"></i>
                        </span>
                        <span class="hide-menu">Data Absensi</span>
                    </a>
                </li>
            @elseif (Auth::user()->role === 'Guru')
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('absensi' ? 'active' : '') }}" href="absensi">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('data-absensi' ? 'active' : '') }}" href="data-absensi">
                        <span>
                            <i class="ti ti-table"></i>
                        </span>
                        <span class="hide-menu">Data Absensi</span>
                    </a>
                </li>
            @else
                <li class="sidebar-item">
                    <a class="sidebar-link{{ Request::is('beranda' ? 'active' : '') }}" href="beranda">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('data-absensi-siswa' ? 'active' : '') }}"
                        href="data-absensi-siswa">
                        <span>
                            <i class="ti ti-table"></i>
                        </span>
                        <span class="hide-menu">Data Absensi Siswa</span>
                    </a>
                </li>
            @endif
            {{-- berlaku di semua role --}}
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" onclick="logout(event)">
                    <i class="ti ti-logout"></i>
                    <span class="hide-menu">Logout</span>
                </a>

            <form id="logout-form" action="{{ route('sign-out') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
    </section>
    <!-- End Sidebar scroll-->
</aside>

<script>
    function logout(event) {
        event.preventDefault();
        if(confirm('Logout Gak?')){
            document.getElementById('logout-form').submit();
        }
    }
</script>
