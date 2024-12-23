<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container-fluid">
      <button class="btn btn-light d-lg-none" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
      <div class="ms-auto">
        <!-- Profile Dropdown -->
        <div class="dropdown">
          <button class="btn d-flex align-items-center gap-2" data-bs-toggle="dropdown">
            <div class="text-start">
              <h6 class="mb-0">{{ auth()->user()->name }}</h6>
              <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
            </div>
            <i class="fas fa-chevron-down ms-2"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end profile-dropdown">

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
