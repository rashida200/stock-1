<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container-fluid">
      <button class="btn btn-light d-lg-none" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
      <div class="ms-auto">
        <!-- Profile Dropdown -->
        <div class="dropdown">
          <button class="btn d-flex align-items-center gap-2" data-bs-toggle="dropdown">
            <img
              src="https://fakeimg.pl/40x40/ff0000,128/000,255"
              class="rounded-circle"
              alt="Profile"
              width="40"
              height="40"
            />
            <div class="text-start">
              <h6 class="mb-0">{{ auth()->user()->name }}</h6>
              <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
            </div>
            <i class="fas fa-chevron-down ms-2"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
            <li>
              <a class="dropdown-item" href="#">
                <i class="fas fa-user me-2"></i>Profile
              </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>

            </li>
          </ul>
        </div>
      </div>
    </div>
</nav>
