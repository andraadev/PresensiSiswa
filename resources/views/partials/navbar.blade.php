<header class="app-header">
    <nav class="navbar navbar-expand-lg" style="background-color: rgb(31,54,46)">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2 text-white"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block d-lg-block d-xl-block d-xl-block">
                <h1 class="ms-3 text-white">
                    {{ $header }}
                </h1>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav" style="background-color: rgb(31,54,46);">
            <ul class="navbar-nav flex-row ms-auto justify-content-end p-2">
                <li class="nav-item dropdown">
                    <button class="text-dark fw-bold btn" role="button" id="dropdownProfile" data-bs-toggle="dropdown"
                        style="background-color: #caeb73;">
                        {{ Auth::user()->username }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="#" class="dropdown-item" onclick="modal_logout()">
                                <i class="ti ti-logout" style="font-size: 22px"></i>
                                Log out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
