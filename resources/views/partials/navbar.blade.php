<header class="app-header">
    <nav class="navbar navbar-expand-lg" style="background-color: rgb(31,54,46)">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2 text-white"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block d-lg-block d-xl-block d-xl-block">
                <h3 class="ms-3 text-white">
                    {{ $header }}
                </h3>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav" style="background-color: rgb(31,54,46);">
            <ul class="navbar-nav flex-row ms-auto justify-content-end p-2">
                <li class="nav-item dropdown">
                    <button class="text-dark fw-bold btn" role="button" id="dropdownProfile" data-bs-toggle="dropdown"
                        style="background-color: #caeb73;">
                        <i class="ti ti-user fw-bold" style="font-size: 20px"></i>
                        {{ Auth::user()->username }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="#" class="dropdown-item" onclick="alert('Silakan Hubungi Administrator untuk Me-reset Passwordmu')">
                                <i class="ti ti-lock" style="font-size: 22px"></i>
                                Lupa Password?
                            </a>
                            <a href="#" class="dropdown-item" onclick="logout(event)">
                                <i class="ti ti-logout" style="font-size: 22px"></i>
                                Log out

                                <form id="logout-form" action="{{ route('sign-out') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script>
    function logout(event) {
        event.preventDefault();
        if(confirm('Logout Gak?')){
            document.getElementById('logout-form').submit();
        }
    }
</script>
