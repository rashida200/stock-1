@foreach ($produits as $produit)
<div class="modal fade" id="editModal-{{ $produit->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('produits.update', $produit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Reference Field (Readonly) -->
                    <div class="mb-3">
                        <label for="reference" class="form-label">Référence</label>
                        <input type="text" class="form-control" id="reference" name="reference" value="{{ $produit->reference }}" readonly>
                    </div>

                    <!-- Designation Field -->
                    <div class="mb-3">
                        <label for="designation" class="form-label">Désignation</label>
                        <input type="text" class="form-control" id="designation" name="designation" value="{{ $produit->designation }}" required>
                    </div>

                    <!-- Quantity Field -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $produit->quantity }}" min="1" required>
                    </div>
                    <!-- Quantity Field -->
                    <div class="mb-3">
                        <label for="quantite_initial" class="form-label">Quantité Initial</label>
                        <input type="number" class="form-control" id="quantite_initial" name="quantite_initial" value="{{ $produit->quantite_initial }}" min="1" required>
                    </div>

                    <!-- Prix d'Achat HT Field -->
                    <div class="mb-3">
                        <label for="prix_achat_ht" class="form-label">Prix d'achat HT</label>
                        <input type="number" step="0.01" class="form-control" id="prix_achat_ht" name="prix_achat_ht" value="{{ $produit->prix_achat_ht }}" required>
                    </div>

                    <!-- TVA Field -->
                    <div class="mb-3">
                        <label for="tva" class="form-label">TVA (%)</label>
                        <select name="tva" class="form-control me-2" required>
                            <option value="7" {{ $produit->tva == 7 ? 'selected' : '' }}>7%</option>
                            <option value="10" {{ $produit->tva == 10 ? 'selected' : '' }}>10%</option>
                            <option value="20" {{ $produit->tva == 20 ? 'selected' : '' }}>20%</option>
                        </select>
                    </div>

                    <!-- Prix de Vente Field -->
                    <div class="mb-3">
                        <label for="prix_vente" class="form-label">Prix de Vente</label>
                        <input type="number" step="0.01" class="form-control" id="prix_vente" name="prix_vente" value="{{ $produit->prix_vente }}" required>
                    </div>

                    <!-- Fournisseur Field -->
                    <div class="mb-3">
                        <label for="fournisseur_id" class="form-label">Fournisseur</label>
                        <select class="form-control" id="fournisseur_id" name="fournisseur_id" required>
                            <option value="">Choisir un fournisseur</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}" @if($produit->fournisseur_id == $fournisseur->id) selected @endif>
                                    {{ $fournisseur->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
