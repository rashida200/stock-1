<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('produits.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Ajouter un Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Reference Field -->
                    <div class="mb-3">
                        <label for="reference" class="form-label">Référence</label>
                        @php
                            $lastProduit = \App\Models\Produit::orderBy('id', 'desc')->first();

                            $lastReference = $lastProduit ? $lastProduit->reference : '1-0000';

                            $lastNumber = (int) substr($lastReference, 2);

                            $newReference = '1-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                        @endphp


                        <input type="text" class="form-control" id="reference" name="reference"
                            value="{{ $newReference }}" required readonly>

                    </div>

                    <!-- Designation Field -->
                    <div class="mb-3">
                        <label for="designation" class="form-label">Désignation</label>
                        <input type="text" class="form-control" id="designation" name="designation" required>
                    </div>

                    <!-- Quantity Field -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                            required>
                    </div>

                    <!-- Prix d'Achat HT Field -->
                    <div class="mb-3">
                        <label for="prix_achat_ht" class="form-label">Prix d'achat HT</label>
                        <input type="number" step="0.01" class="form-control" id="prix_achat_ht"
                            name="prix_achat_ht" required>
                    </div>

                    <!-- TVA Field -->
                    <div class="mb-3">
                        <label for="tva" class="form-label">TVA (%)</label>
                        <input type="number" step="0.01" class="form-control" id="tva" name="tva"
                            required>
                    </div>

                    <!-- Prix de Vente Field -->
                    <div class="mb-3">
                        <label for="prix_vente" class="form-label">Prix de Vente</label>
                        <input type="number" step="0.01" class="form-control" id="prix_vente" name="prix_vente"
                            required>
                    </div>

                    <!-- Fournisseur Field -->
                    <div class="mb-3">
                        <label for="fournisseur_id" class="form-label">Fournisseur</label>
                        <select class="form-control" id="fournisseur_id" name="fournisseur_id" required>
                            <option value="">Choisir un fournisseur</option>
                            @foreach ($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
