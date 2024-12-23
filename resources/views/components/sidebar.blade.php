<nav class="nav flex-column">
    <!-- Dashboard Link -->
   @if (auth()->user()->type === 'admin')
    <a class="nav-link mb-2 rounded {{ request()->is('admin')? 'active' : '' }}"
    href="/home">
    <i class="fas fa-home me-2"></i>Dashboard
</a>
   @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
        <a class="nav-link mb-2 rounded {{ request()->is('fournisseurs*') ? 'active' : '' }}"
            href="{{ route('admin.fournisseurs') }}">
            <i class="fas fa-truck me-2"></i>Fournisseurs
        </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager')
        <a class="nav-link mb-2 rounded {{ request()->is('utilisateurs*') ? 'active' : '' }}"
            href="{{ route('utilisateurs.index') }}">
            <i class="fas fa-user-friends me-2"></i>Utilisateurs
        </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
        <a class="nav-link mb-2 rounded {{ request()->is('produits*') ? 'active' : '' }}"
            href="{{ route('produits.index') }}">
            <i class="fas fa-box me-2"></i>Produits
        </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
        <a class="nav-link mb-2 rounded {{ request()->is('clients*') ? 'active' : '' }}" href="{{route('clients.index')}}">
            <i class="fas fa-users me-2"></i>Clients
        </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
    <div class="nav-item dropdown">
        <a class="nav-link mb-2 rounded {{ request()->is('bons') ? 'active' : '' }}" href="#" id="bonsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-file-invoice me-2"></i>Bons
        </a>
        <ul class="dropdown-menu" aria-labelledby="bonsDropdown">
            <li>
                <a class="dropdown-item {{ request()->is('bons-commande*') ? 'active' : '' }}" href="{{ route('bons-commande.index') }}">
                    Bon De Commande
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->is('devis*') ? 'active' : '' }}" href="{{ route('devis.index') }}">
                    Devis
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->is('bons-livraison*') ? 'active' : '' }}" href="{{ route('bons-livraison.index') }}">
                    Bon De Livraison
                </a>
            </li>
        </ul>
    </div>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager')
    <a class="nav-link mb-2 rounded {{ request()->is('factures') ? 'active' : '' }}"
        href="{{ route('factures.index') }}">
        <i class="fas fa-warehouse me-2"></i>Factures
    </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
        <a class="nav-link mb-2 rounded {{ request()->is('commandes*') ? 'active' : '' }}" href="{{route('commandes.index')}}">
            <i class="fas fa-file-invoice me-2"></i>Commandes Client
        </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
    <a class="nav-link mb-2 rounded {{ request()->is('stock*') ? 'active' : '' }}"
        href="{{ route('stock.index') }}">
        <i class="fas fa-warehouse me-2"></i>Stock
    </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager')
    <a class="nav-link mb-2 rounded {{ request()->is('banques*') ? 'active' : '' }}"
        href="{{ route('banques.index') }}">
        <i class="fa-solid fa-money-check-dollar"></i> Banque
    </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
    <a class="nav-link mb-2 rounded {{ request()->is('identifiants*') ? 'active' : '' }}"
        href="{{ route('identifiants.show') }}">
        <i class="fa-solid fa-money-check-dollar"></i> Identifiant
    </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
    <a class="nav-link mb-2 rounded {{ request()->is('bons-avoir*') ? 'active' : '' }}"
        href="{{ route('bons-avoir.index') }}">
        <i class="fa-solid fa-money-check-dollar"></i> bons-avoir
    </a>
    @endif
    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'manager' || auth()->user()->type === 'commercial')
    <a class="nav-link mb-2 rounded {{ request()->is('factures-avoir*') ? 'active' : '' }}"
        href="{{ route('factures-avoir.index') }}">
        <i class="fa-solid fa-money-check-dollar"></i> factures-avoir
    </a>
    @endif

</nav>
