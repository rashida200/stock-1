<x-base>
    <div class="container">
        <h1>Modifier le Bon de Commande</h1>

        <form action="{{ route('commandes.update', $commandeClient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h5>Modifier Commande #{{ $commandeClient->id }}</h5>
            <label for="statut">Statut</label>
            <select name="statut" id="statut" class="form-control">
                <option value="en attente" {{ $commandeClient->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="expediée" {{ $commandeClient->statut == 'expediée' ? 'selected' : '' }}>Expédiée</option>
                <option value="livree" {{ $commandeClient->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                <option value="annulee" {{ $commandeClient->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
            </select>
            

            {{-- afficher client --}}
            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select class="form-control w-100" id="client_id" name="client_id" required>
                    <option value="">Choisir un client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" @if(old('client_id', $commandeClient->client_id) == $client->id) selected @endif>
                            {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="date_commande" class="form-label">Date de Commande</label>
                <input type="date" class="form-control w-100" id="date_commande" name="date_commande" value="{{ $commandeClient->date_commande }}" required>
            </div>
            
            {{-- REGLEMENT --}}
            <div class="mb-3">
                <label for="reglement" class="form-label">Mode de Réglement</label>
                <select class="form-control w-100" id="reglement" name="reglement" required>
                    <option value="Espèce" @if($commandeClient->reglement == 'Espèce') selected @endif>Espèce</option>
                    <option value="Chèque" @if($commandeClient->reglement == 'Chèque') selected @endif>Chèque</option>
                    <option value="LCTraite" @if($commandeClient->reglement == 'LCTraite') selected @endif>LC Traite</option>
                    <option value="Virement" @if($commandeClient->reglement == 'Virement') selected @endif>Virement</option>
                    <option value="Prélèvement" @if($commandeClient->reglement == 'Prélèvement') selected @endif>Prélèvement</option>
                    <option value="En Compte" @if($commandeClient->reglement == 'En Compte') selected @endif>En Compte</option>
                    <option value="Délégation de créance" @if($commandeClient->reglement == 'Délégation de créance') selected @endif>Délégation de créance</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ref-regl">Réference réglement</label>
                <input type="text" name="ref_regl" class="form-control w-100" value="{{$commandeClient->ref_regl }}">
            </div>
            <div class="mb-3">
                <label for="produits" class="form-label">Produits Associés</label>
                <table class="table table-bordered" id="produits-table-{{ $commandeClient->id }}">
                    <thead>
                        <tr>
                            <th>Nom du Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Remise (%)</th>
                            <th>TVA</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="produits-list-{{ $commandeClient->id }}">
                        @foreach ($commandeClient->produits as $produit)
                        <tr id="produit-{{ $produit->id }}-{{ $commandeClient->id }}">
                            <td>{{ $produit->designation ?? 'N/A' }}</td>
                            <td>
                                <input type="number" class="form-control w-100" name="produit_{{ $produit->id }}_qte" value="{{ $produit->pivot->qte_vte ?? 0 }}" min="0" required>
                            </td>
                            <td>
                                <input type="number" class="form-control w-100" name="produit_{{ $produit->id }}_prix" value="{{ $produit->pivot->prix_unitaire ?? 0 }}" step="0.01" required>
                            </td>
                            <td>
                                <input type="text" class="form-control w-400" name="produit_{{ $produit->id }}_remise" value="{{ $produit->pivot->remise ?? 0 }}" min="0" max="100" step="0.01" required>
                            </td>
                            <td>
                                <select class="form-control w-100" name="produit_{{ $produit->id }}_tva" required>
                                    <option value="7" @if($produit->pivot->tva == '7') selected @endif>7%</option>
                                    <option value="10" @if($produit->pivot->tva  == '10') selected @endif>10%</option>
                                    <option value="20" @if($produit->pivot->tva  == '20') selected @endif>20%</option>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="removeProduit({{ $produit->id }}, {{ $commandeClient->id }})">Supprimer</button>
                                <input type="hidden" name="supprimer_produit[]" value="{{ $produit->id }}" id="supprimer_produit_{{ $produit->id }}-{{ $commandeClient->id }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3">
                    <button type="button" class="btn btn-success" onclick="addProduit({{ $commandeClient->id }})">Ajouter un produit</button>
                </div>
            </div>
            {{-- bouton soumettre --}}
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Fonction pour ajouter un produit
    function addProduit(commandeId) {
        // Données des produits à injecter (assurez-vous que $produits est bien passé au script)
        const produits = @json($produits);

        // Crée les options pour la liste déroulante
        const options = produits.map(produit => `
            <option value="${produit.id}">${produit.designation}</option>
        `).join('');

        // Structure de la nouvelle ligne à ajouter
        const newRow = `
            <tr>
                <td>
                    <select class="form-control w-100" name="nouveau_produit_id[]" required>
                        <option value="">Choisir un produit</option>
                        ${options}
                    </select>
                </td>
                <td><input type="number" class="form-control" name="nouveau_produit_qte[]" min="1" required></td>
                <td><input type="number" class="form-control" name="nouveau_produit_prix[]" step="0.01" required></td>
                <td><input type="number" class="form-control" name="nouveau_produit_remise[]" min="0" max="100" step="0.01" required></td>
                <td>
                    <select class="form-control" name="nouveau_produit_tva[]" required>
                        <option value="7">7%</option>
                        <option value="10">10%</option>
                        <option value="20">20%</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger" onclick="removeProduitTemp(this)">Supprimer</button></td>
            </tr>
        `;

        // Ajoute la ligne au tableau
        const produitsList = document.getElementById(`produits-list-${commandeId}`);
        produitsList.insertAdjacentHTML('beforeend', newRow);
    }

    // Fonction pour supprimer un produit ajouté temporairement
    function removeProduitTemp(button) {
        const row = button.closest('tr');
        row.remove(); // Supprime la ligne du tableau
    }

    // Fonction pour supprimer un produit existant (enregistrement logique)
    function removeProduit(produitId, commandeId) {
        const row = document.getElementById(`produit-${produitId}-${commandeId}`);
        const input = document.getElementById(`supprimer_produit_${produitId}-${commandeId}`);
        
        if (row && input) {
            row.style.display = 'none'; // Cache la ligne du produit
            input.value = produitId; // Indique qu'il faut supprimer ce produit
        }
    }

    // Expose les fonctions au contexte global pour les utiliser dans les attributs HTML
    window.addProduit = addProduit;
    window.removeProduitTemp = removeProduitTemp;
    window.removeProduit = removeProduit;
});

    </script>
   
</x-base>
