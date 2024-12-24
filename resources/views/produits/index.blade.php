<x-base>
    @section('title', 'Produits')
    <div class="table-responsive small">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Ajouter Produit
            </button>
            @endif
            <form action="{{ route('produits.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Rechercher par référence ou désignation" value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary me-2">Rechercher</button>
                <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">Retour</a>
            </form>
        </div>
        <table class="table table-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Référence</th>
                    <th scope="col">Désignation</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Quantité initial</th>
                    <th scope="col">Prix d'achat</th>
                    <th scope="col">TVA</th>
                    <th scope="col">Prix d'achat TTC</th>
                    <th scope="col">Prix de Vente</th>
                    <th scope="col">Total HT</th>
                    <th scope="col">Total TTC</th>
                    <th scope="col">Fournisseur</th>
                    @if (auth()->user()->type === 'admin' || auth()->user()->type === 'commercial')
                    <th scope="col">Actions</th>
                    @endif

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
                            <td>{{ $produit->quantite_initial }}</td>
                            <td>{{ $produit->prix_achat_ht }}</td>
                            <td>{{ $produit->tva }}</td>
                            <td>{{ $produit->prix_achat_ttc }}</td>
                            <td>{{ $produit->prix_vente }}</td>
                            <td>{{ $produit->total_ht }}</td>
                            <td>{{ $produit->total_ttc }}</td>
                            <td>{{ $produit->fournisseur->nom }}</td>
                            @if (auth()->user()->type === 'admin' || auth()->user()->type === 'commercial')
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-1">

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $produit->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>


                                </div>
                            </td>
                            @endif
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
