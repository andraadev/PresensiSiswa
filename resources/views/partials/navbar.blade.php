  <nav class="navbar admin-navbar navbar-expand bg-white">
      <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
              aria-expanded="true" aria-label="Toggle sidebar">
              <span></span>
              <span></span>
              <span></span>
          </button>

          <div class="navbar-actions ms-auto">
              <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme"
                  title="Switch color theme">
                  <i class="ti ti-moon-stars" data-theme-icon aria-hidden="true"></i>
              </button>
              <div class="dropdown">
                  <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ti ti-user-circle"></i>
                      <span class=" d-none d-sm-inline">{{ Auth::user()->username }}</span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item d-flex gap-2" href="javascript:void(0)" onclick="modal_logout()">
                              <i class="ti ti-logout sidebar-icon" aria-hidden="true"></i>
                              Keluar
                          </a>
                          <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                              @csrf
                          </form>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </nav>
