<x-base>
    <div class="container">
        <h1>Modifier le Bon de Commande</h1>

        <form action="{{ route('bons-commande.update', $bonCommande->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="fournisseur_id" class="form-label">Fournisseur</label>
                <select name="fournisseur_id" id="fournisseur_id" class="form-control">
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}" 
                            {{ $bonCommande->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col">
                    <label>Date de Commande</label>
                    <input type="date" name="date_commande" value="{{ $bonCommande->date_commande }}" class="form-control" />
                </div>
                <div class="col">
                    <label>Statut</label>
                    <select name="statut" class="form-control">
                        <option value="attente" {{ old('statut', $bonCommande->statut) == 'attente' ? 'selected' : '' }}>En Attente</option>
                        <option value="valide" {{ old('statut', $bonCommande->statut) == 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="annule" {{ old('statut', $bonCommande->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
            </div>

            <hr>

            <h5>Détails du Bon</h5>
            <div id="details">
                @foreach ($bonCommande->details as $index => $detail)
                    <div class="row mb-2 produit-ligne">
                        <div class="col">
                            <label>Produit</label>
                            <select name="references[]" class="form-control">
                                <option value="">Sélectionner un produit</option>
                                @foreach ($produits as $produit)
                                    <option value="{{ $produit->reference }}" 
                                        {{ $detail->reference_produit == $produit->reference ? 'selected' : '' }}>
                                        {{ $produit->reference }} - {{ $produit->designation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>Quantité</label>
                            <input type="number" name="quantites[]" value="{{ $detail->quantite }}" class="form-control" />
                        </div>
                        <div class="col">
                            <label>Prix HT</label>
                            <input type="number" step="0.01" name="prix_unitaire_ht[]" value="{{ $detail->prix_unitaire_ht }}" class="form-control" />
                        </div>
                        <div class="col">
                            <label>TVA (%)</label>
                            <select class="form-control" name="tva[]">
                                <option value="7" {{ $detail->tva == 7 ? 'selected' : '' }}>7%</option>
                                <option value="10" {{ $detail->tva == 10 ? 'selected' : '' }}>10%</option>
                                <option value="20" {{ $detail->tva == 20 ? 'selected' : '' }}>20%</option>
                            </select>
                        </div>
                        <div class="col d-flex align-items-end">
                            <button type="button" class="btn btn-danger supprimer-produit">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="ajouter-produit">
                    <i class="fas fa-plus"></i> Ajouter un Produit
                </button>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Modifier</button>
            <a href="{{ route('bons-commande.index') }}" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ajouterProduitBtn = document.getElementById('ajouter-produit');
            const detailsContainer = document.getElementById('details');

            // Fonction pour ajouter une nouvelle ligne
            ajouterProduitBtn.addEventListener('click', () => {
                // Cloner la première ligne existante
                const premiereLigne = document.querySelector('.produit-ligne');
                if (!premiereLigne) {
                    alert("Aucune ligne modèle trouvée !");
                    return;
                }

                const nouvelleLigne = premiereLigne.cloneNode(true);

                // Réinitialiser les champs de la nouvelle ligne
                nouvelleLigne.querySelectorAll('input').forEach(input => input.value = '');
                nouvelleLigne.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                // Ajouter un gestionnaire de suppression pour la nouvelle ligne
                ajouterGestionSuppression(nouvelleLigne);

                // Ajouter la nouvelle ligne au conteneur
                detailsContainer.appendChild(nouvelleLigne);
            });

            // Fonction pour ajouter un gestionnaire de suppression à une ligne
            function ajouterGestionSuppression(ligne) {
                const boutonSupprimer = ligne.querySelector('.supprimer-produit');
                boutonSupprimer.addEventListener('click', () => {
                    if (detailsContainer.querySelectorAll('.produit-ligne').length > 1) {
                        ligne.remove();
                    } else {
                        alert("Il doit y avoir au moins une ligne de produit.");
                    }
                });
            }

            // Appliquer la suppression à toutes les lignes existantes
            detailsContainer.querySelectorAll('.produit-ligne').forEach(ajouterGestionSuppression);
        });
    </script>
    @endpush
</x-base>
