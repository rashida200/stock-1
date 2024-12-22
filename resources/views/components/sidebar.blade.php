<nav class="nav flex-column">
    <!-- Dashboard Link -->
    <a class="nav-link mb-2 rounded {{ request()->is('admin') || request()->is('manager') || request()->is('commercial') ? 'active' : '' }}"
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
    <div class="nav-item dropdown">
        <a class="nav-link mb-2 rounded {{ request()->is('admin/bons*') ? 'active' : '' }}" href="#" id="bonsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-file-invoice me-2"></i>Bons
        </a>
        <ul class="dropdown-menu" aria-labelledby="bonsDropdown">
            <li>
                <a class="dropdown-item {{ request()->is('admin/bons-commande*') ? 'active' : '' }}" href="{{ route('bons-commande.index') }}">
                    Bon De Commande
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->is('admin/devis*') ? 'active' : '' }}" href="{{ route('devis.index') }}">
                    Devis
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->is('admin/bons-livraison*') ? 'active' : '' }}" href="{{ route('bons-livraison.index') }}">
                    Bon De Livraison
                </a>
            </li>
        </ul>
    </div>
    @endif
    @if (auth()->user()->type === 'admin')
    <a class="nav-link mb-2 rounded {{ request()->is('admin/factures*') ? 'active' : '' }}"
        href="{{ route('factures.index') }}">
        <i class="fas fa-warehouse me-2"></i>Facture
    </a>
    @endif
    @if (auth()->user()->type === 'admin')
        <a class="nav-link mb-2 rounded {{ request()->is('admin/commandes*') ? 'active' : '' }}" href="{{route('commandes.index')}}">
            <i class="fas fa-file-invoice me-2"></i>Commandes Client
        </a>
    @endif
    @if (auth()->user()->type === 'admin')
    <a class="nav-link mb-2 rounded {{ request()->is('admin/stock*') ? 'active' : '' }}"
        href="{{ route('stock.index') }}">
        <i class="fas fa-warehouse me-2"></i>Stock
    </a>
    @endif
    @if (auth()->user()->type === 'admin')
    <a class="nav-link mb-2 rounded {{ request()->is('admin/banques*') ? 'active' : '' }}"
        href="{{ route('banques.index') }}">
        <i class="fa-solid fa-money-check-dollar"></i> Banque
    </a>
    @endif
    @if (auth()->user()->type === 'admin')
    <a class="nav-link mb-2 rounded {{ request()->is('admin/identifiants*') ? 'active' : '' }}"
        href="{{ route('identifiants.show') }}">
        <i class="fa-solid fa-money-check-dollar"></i> Identifiant
    </a>
    @endif

</nav>
