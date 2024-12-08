<nav class="nav flex-column">
    <!-- Dashboard Link -->
    <a class="nav-link mb-2 rounded {{ request()->is('admin') || request()->is('manager') || request()->is('cashier') ? 'active' : '' }}" href="/home">
      <i class="fas fa-home me-2"></i>Dashboard
    </a>
    <!-- Fournisseurs Link: Admin Access -->
    @if (auth()->user()->type === 'admin')
      <a class="nav-link mb-2 rounded {{ request()->is('admin/fournisseurs*') ? 'active' : '' }}" href="{{ route('admin.fournisseurs') }}">
        <i class="fas fa-cog me-2"></i>Fournisseurs
      </a>
    @endif
</nav>
