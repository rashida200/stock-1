<nav class="nav flex-column">
    <!-- Dashboard Link -->
    <a class="nav-link active mb-2 rounded" href="#">
      <i class="fas fa-home me-2"></i>Dashboard
    </a>

    <!-- Inventory Link: Cashier Access -->
    @if (auth()->user()->type === 'cashier' ||  auth()->user()->type === 'admin')
      <a class="nav-link mb-2 rounded" href="#">
        <i class="fas fa-box me-2"></i>Inventory
      </a>
    @endif

    <!-- Orders Link: Manager Access -->
    @if (auth()->user()->type == 'manager' ||  auth()->user()->type === 'admin')
      <a class="nav-link mb-2 rounded" href="#">
        <i class="fas fa-shopping-cart me-2"></i>Orders
      </a>
    @endif

    <!-- Reports Link: Manager Access -->
    @if (auth()->user()->type !=='manager' ||  auth()->user()->type === 'admin')
      <a class="nav-link mb-2 rounded" href="#">
        <i class="fas fa-chart-bar me-2"></i>Reports
      </a>
    @endif

    <!-- Settings Link: Manager Access -->
    @if (auth()->user()->type !== 'manager' || auth()->user()->type === 'admin')
      <a class="nav-link mb-2 rounded" href="#">
        <i class="fas fa-cog me-2"></i>Settings
      </a>
    @endif
  </nav>
