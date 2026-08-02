@php
    $userRole = Auth::user()->role;

    $menus = [
        [
            'label' => 'Beranda',
            'route' => match ($userRole) {
                'BK' => 'bk.beranda',
                default => 'admin.beranda',
            },
            'pattern' => '*beranda*',
            'icon' => 'ti-home',
            'roles' => ['Admin', 'BK'],
        ],
        [
            'label' => 'Presensi',
            'route' => 'absensi.index',
            'pattern' => 'absensi*',
            'icon' => 'ti-clipboard-check',
            'roles' => ['Guru'],
        ],
        [
            'label' => 'Data Guru',
            'route' => 'data-guru.index',
            'pattern' => 'data-guru*',
            'icon' => 'ti-chalkboard',
            'roles' => ['Admin'],
        ],
        [
            'label' => 'Data Siswa',
            'route' => 'data-siswa.index',
            'pattern' => 'data-siswa*',
            'icon' => 'ti-school',
            'roles' => ['Admin'],
        ],
        [
            'label' => 'Data Kelas',
            'route' => 'data-kelas.index',
            'pattern' => 'data-kelas*',
            'icon' => 'ti-building',
            'roles' => ['Admin'],
        ],
        [
            'label' => 'Data User',
            'route' => 'data-user.index',
            'pattern' => 'data-user*',
            'icon' => 'ti-user-check',
            'roles' => ['Admin'],
        ],
        [
            'label' => 'Data Absensi',
            'route' => match ($userRole) {
                'Guru' => 'guru.data_absensi',
                'BK' => 'bk.data_absensi',
                default => 'admin.data_absensi',
            },
            'pattern' => '*data_absensi*',
            'icon' => 'ti-table',
            'roles' => ['Admin', 'Guru', 'BK'],
        ],
        [
            'label' => 'Rekapitulasi Absensi',
            'route' => match ($userRole) {
                'Admin' => 'admin.rekapitulasi',
                'BK' => 'bk.rekapitulasi',
                default => '#',
            },
            'pattern' => '*rekapitulasi-absensi*',
            'icon' => 'ti-clipboard-check',
            'roles' => ['Admin', 'BK'],
        ],
    ];
@endphp

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="brand-logo d-flex justify-content-center align-items-center">
        <h2 class="text-white fw-bolder">PresensiSiswa</h2>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            @foreach ($menus as $menu)
                @if (in_array($userRole, $menu['roles']))
                    @php
                        $url = route($menu['route']);
                        $isActive = request()->routeIs($menu['pattern']);
                    @endphp
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                            <span>
                                <i class="ti {{ $menu['icon'] }} sidebar-icon"></i>
                            </span>
                            <span class="hide-menu">{{ $menu['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
            <li class="sidebar-item">
                <a href="javascript:void(0)" class="sidebar-link" onclick="modal_logout()">
                    <span>
                        <i class="ti ti-logout sidebar-icon"></i>
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                        @csrf
                    </form>
                    <span class="hide-menu">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</aside>
