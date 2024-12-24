<x-base>
    @section('title', 'Stock')
    <div class="container">
        <h1 class="mb-4">Gestion de Stock</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('stock.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Chercher dans le stock..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </form>

        <!-- Alerts -->
        <x-stock-alert :produits="$produits" />

        <!-- Stock Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Quantité</th>
                    <th>Quantité initiale</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produits as $produit)
                    <tr>
                        <td>{{ $produit->reference }}</td>
                        <td>{{ $produit->designation }}</td>
                        <td>{{ $produit->quantity }}</td>
                        <td>{{ $produit->quantite_initial }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucun Produit trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $produits->links() }}
    </div>
</x-base>
