<x-base>

    <div class="container">
        <h1>Nouveau Bon de Commande</h1>

        <form action="{{ route('bons-commande.store') }}" method="POST" id="bonCommandeForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fournisseur</label>
                                <select name="fournisseur_id" class="form-control @error('fournisseur_id') is-invalid @enderror" required>
                                    <option value="">Sélectionner un fournisseur</option>
                                    @foreach($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                                            {{ $fournisseur->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fournisseur_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date de commande</label>
                                <input type="date" name="date_commande" class="form-control @error('date_commande') is-invalid @enderror"
                                       value="{{ old('date_commande', date('Y-m-d')) }}" required>
                                @error('date_commande')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h3>Produits</h3>
                    <div id="produits-container">
                        <div class="produit-ligne mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Produit</label>
                                        <select name="references[]" class="form-control" required>
                                            <option value="">Sélectionner un produit</option>
                                            @foreach($produits as $produit)
                                                <option value="{{ $produit->reference }}">
                                                    {{ $produit->reference }} - {{ $produit->designation }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Quantité</label>
                                        <input type="number" name="quantites[]" class="form-control" required min="1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Prix unitaire HT</label>
                                        <input type="number" step="0.01" name="prix_unitaire_ht[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>TVA (%)</label>
                                        <input type="number" step="0.01" name="tva[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-supprimer-produit">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="btn-ajouter-produit">
                            <i class="fas fa-plus"></i> Ajouter un produit
                        </button>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer le bon de commande
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const produitsContainer = document.getElementById('produits-container');
        const btnAjouterProduit = document.getElementById('btn-ajouter-produit');

        // Add product line
        btnAjouterProduit.addEventListener('click', () => {
            const ligne = produitsContainer.querySelector('.produit-ligne').cloneNode(true);

            // Reset fields in the cloned line
            ligne.querySelectorAll('input, select').forEach(input => input.value = '');

            // Add delete handler to the cloned line
            addDeleteHandler(ligne);

            produitsContainer.appendChild(ligne);
        });

        // Add delete handler to existing and new lines
        function addDeleteHandler(ligne) {
            const deleteBtn = ligne.querySelector('.btn-supprimer-produit');
            deleteBtn.addEventListener('click', () => {
                if (produitsContainer.querySelectorAll('.produit-ligne').length > 1) {
                    ligne.remove();
                } else {
                    alert('Vous devez avoir au moins une ligne de produit.');
                }
            });
        }

        // Apply delete handler to the initial product line
        produitsContainer.querySelectorAll('.produit-ligne').forEach(addDeleteHandler);
    });
    </script>
    @endpush


</x-base>
