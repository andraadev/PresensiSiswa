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

<div class="sidebar-backdrop" data-sidebar-close></div>
<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
        <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
            <span class="brand-icon">
                <i class="ti ti-clipboard-check" aria-hidden="true"></i>
            </span>
            <span class="brand-copy">
                <span class="brand-title fs-4">PresensiSiswa</span>
            </span>
        </a>
    </div>
    <nav class="sidebar-nav">
        @foreach ($menus as $menu)
            @if (in_array($userRole, $menu['roles']))
                @php
                    $url = route($menu['route']);
                    $isActive = request()->routeIs($menu['pattern']);
                @endphp
                <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ $url }}" aria-current="page">
                    <span class="nav-icon">
                        <i class="ti {{ $menu['icon'] }}" aria-hidden="true"></i>
                    </span>
                    <span class="nav-text">{{ $menu['label'] }}</span>
                </a>
            @endif
        @endforeach
        <a class="nav-link" href="javascript:void(0)" onclick="modal_logout()">
            <span class="nav-icon">
                <i class="ti ti-logout sidebar-icon" aria-hidden="true"></i>
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                @csrf
            </form>
            <span class="nav-text">Keluar</span>
        </a>
    </nav>
</aside>
