<x-base>
    @section('title', 'Produits')
    <div class="table-responsive small">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Ajouter Produit
            </button>
            <form action="{{ route('produits.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Rechercher par référence ou désignation" value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary me-2">Rechercher</button>
                <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">Reset</a>
            </form>
        </div>





        <table class="table table-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Reference</th>
                    <th scope="col">Designation</th>
                    <th scope="col">quantity</th>
                    <th scope="col">Prix d'achat</th>
                    <th scope="col">tva</th>
                    <th scope="col">Prix d'achat TTC</th>
                    <th scope="col">Prix de Vente</th>
                    <th scope="col">Total HT</th>
                    <th scope="col">Total TTC</th>
                    <th scope="col">Fournisseur</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($produits->isEmpty())
                    <tr>
                        <td colspan="11">Aucun produit trouvé.</td>
                    </tr>
                @else
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->reference }}</td>
                            <td>{{ $produit->designation }}</td>
                            <td>{{ $produit->quantity }}</td>
                            <td>{{ $produit->prix_achat_ht }}</td>
                            <td>{{ $produit->tva }}</td>
                            <td>{{ $produit->prix_achat_ttc }}</td>
                            <td>{{ $produit->prix_vente }}</td>
                            <td>{{ $produit->total_ht }}</td>
                            <td>{{ $produit->total_ttc }}</td>
                            <td>{{ $produit->fournisseur->nom }}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-1">

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $produit->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-primary btn-sm" title="Historique">
                                        <i class="fas fa-history"></i>
                                    </button>
                                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this Produit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>


                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span>
                Affichage de {{ $produits->firstItem() }} à {{ $produits->lastItem() }} sur {{ $produits->total() }}
                entrées
            </span>
            <div class="d-flex justify-content-center">
                {{ $produits->appends(['search' => $search])->links() }}
            </div>
        </div>

    </div>

    <!-- Create Modal -->
    @include('produits.create')
    @include('produits.edit')

</x-base>
