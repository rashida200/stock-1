<x-base>
    <form action="{{ route('bons-livraison.store') }}" method="POST" class="container mt-4">
        @csrf

        <!-- Commandes -->
        <div class="form-group">
            <label for="commandes">Commandes:</label>
            <select name="commande_id" id="commandes" class="form-control" onchange="fillInputs()">
                <option value="">-- Sélectionnez une commande --</option>
                @foreach ($commandes as $commande)
                    <option
                        value="{{ $commande->id }}"
                        data-client-id="{{ $commande->client->id }}"
                        data-client-nom="{{ $commande->client->nom }}"
                        data-client-telephone="{{ $commande->client->telephone }}"
                        data-date-commande="{{ $commande->date_commande }}"
                        data-produits="{{ json_encode($commande->commandeClientProduits) }}">
                        {{ $commande->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Commande details (Client Info) -->
        <div id="commande-details" class="mt-4">
            <div class="form-group">
                <label for="client_id">Client ID:</label>
                <input type="text" id="client_id" name="client_id" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="client_nom">Nom du Client:</label>
                <input type="text" id="client_nom" name="client_nom" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="client_telephone">Téléphone:</label>
                <input type="text" id="client_telephone" name="client_telephone" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="date_commande">Date de Commande:</label>
                <input type="text" id="date_commande" name="date_vente" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="date_livraison">Date de livraison:</label>
                <input type="date" id="date_livraison" name="date_livraison" class="form-control" value="{{ old('date_commande', date('Y-m-d')) }}">
            </div>
        </div>

        <!-- Produit details -->
        <div id="produit-details" class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Référence Produit</th>
                        <th>Désignation Produit</th>
                        <th>Quantité Vente</th>
                        <th>Remise</th>
                        <th>Prix Unitaire</th>
                        <th>Montant HT</th>
                        <th>TVA</th>
                        <th>Montant TTC</th>
                    </tr>
                </thead>
                <tbody id="produit-rows"></tbody>
            </table>
        </div>

        <!-- Champ caché pour envoyer les produits -->
        <input type="hidden" id="produits" name="produits">

        <button type="submit" class="btn btn-primary mt-4">Soumettre</button>
    </form>

    <script>
        function fillInputs() {
    const select = document.getElementById('commandes');
    const selectedOption = select.options[select.selectedIndex];

    // Récupérer les données de l'option sélectionnée
    const clientId = selectedOption.getAttribute('data-client-id');
    const clientNom = selectedOption.getAttribute('data-client-nom');
    const clientTelephone = selectedOption.getAttribute('data-client-telephone');
    const dateCommande = selectedOption.getAttribute('data-date-commande');
    const produitsData = JSON.parse(selectedOption.getAttribute('data-produits'));

    // Remplir les champs client
    document.getElementById('client_id').value = clientId;
    document.getElementById('client_nom').value = clientNom;
    document.getElementById('client_telephone').value = clientTelephone;
    document.getElementById('date_commande').value = dateCommande;

    // Remplir le tableau des produits
    let produitRowsHtml = '';
    let produitsArray = []; // Tableau pour stocker les produits

    produitsData.forEach((produit, index) => {
        produitRowsHtml += `
            <tr>
                <td>${produit.produit.reference}</td>
                <td>${produit.produit.designation}</td>
                <td>${produit.qte_vte}</td>
                <td>${produit.prix_unitaire}</td>
                <td>${produit.montant_ht}</td>
                <td>${produit.tva}</td>
                <td>${produit.montant_ttc}</td>
            </tr>
        `;

        // Ajouter le produit au tableau
        produitsArray.push({
            produit_id: produit.produit.id,
            quantite: produit.qte_vte,
            prix_unitaire_ht: produit.prix_unitaire,
            total_ligne_ht: produit.montant_ht,
            tva: produit.tva,
            total_ligne_ttc: produit.montant_ttc,
        });
    });

    // Injecter les lignes des produits dans le tableau
    document.getElementById('produit-rows').innerHTML = produitRowsHtml;

    // Mettre à jour le champ caché avec les produits
    document.getElementById('produits').value = JSON.stringify(produitsArray);
}


    </script>

</x-base>
