<nav class="nav flex-column">
    <!-- Dashboard Link -->
    <a class="nav-link mb-2 rounded {{ request()->is('admin') || request()->is('manager') || request()->is('cashier') ? 'active' : '' }}"
        href="/home">
        <i class="fas fa-home me-2"></i>Dashboard
    </a>
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/fournisseurs*') ? 'active' : '' }}"
            href="{{ route('admin.fournisseurs') }}">
            <i class="fas fa-truck me-2"></i>Fournisseurs
        </a>
    @endif
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/utilisateurs*') ? 'active' : '' }}"
            href="{{ route('utilisateurs.index') }}">
            <i class="fas fa-user-friends me-2"></i>Utilisateurs
        </a>
    @endif
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/produits*') ? 'active' : '' }}"
            href="{{ route('produits.index') }}">
            <i class="fas fa-box me-2"></i>Produits
        </a>
    @endif
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/clients*') ? 'active' : '' }}" href="{{route('clients.index')}}">
            <i class="fas fa-users me-2"></i>Clients
        </a>
    @endif
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/bons-commande*') ? 'active' : '' }}" href="{{route('bons-commande.index')}}">
            <i class="fas fa-file-invoice me-2"></i>Bon De Commande
        </a>
    @endif
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/devis*') ? 'active' : '' }}" href="{{route('devis.index')}}">
            <i class="fas fa-file-invoice me-2"></i>Devis
        </a>
    @endif



</nav>
