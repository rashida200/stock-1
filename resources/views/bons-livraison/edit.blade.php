<x-base>
    <div class="container">
        <h1>Modifier le Bon de Livraison</h1>

        <form action="{{ route('bons-livraison.update', $bonLivraison->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Client Details -->
            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ $bonLivraison->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dates -->
            <div class="row">
                <div class="col">
                    <label>Date de Vente</label>
                    <input type="date" name="date_vente" value="{{ $bonLivraison->date_vente }}" class="form-control" />
                </div>
                <div class="col">
                    <label>Date de Livraison</label>
                    <input type="date" name="date_livraison" value="{{ $bonLivraison->date_livraison }}" class="form-control" />
                </div>
            </div>

            <hr>

            <!-- Product Details -->
            <h5>Détails du Bon</h5>
            <div id="produit-details" class="mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Référence Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire HT</th>
                            <th>Total Ligne HT</th>
                            <th>TVA</th>
                            <th>Total Ligne TTC</th>
                        </tr>
                    </thead>
                    <tbody id="produit-rows">
                        @foreach ($bonLivraison->details as $detail)
                            <tr>
                                <td>{{ $detail->produit->reference }}</td>
                                <td><input type="number" name="quantites[]" value="{{ $detail->quantite }}" class="form-control"></td>
                                <td><input type="number" step="0.01" name="prix_unitaire_ht[]" value="{{ $detail->prix_unitaire_ht }}" class="form-control"></td>
                                <td>{{ $detail->total_ligne_ht }}</td>
                                <td><input type="number" step="0.01" name="tva[]" value="{{ $detail->tva }}" class="form-control"></td>
                                <td>{{ $detail->total_ligne_ttc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Hidden Field for Products JSON -->
            <input type="hidden" id="produits" name="produits">

            <button type="submit" class="btn btn-primary mt-4">Modifier</button>
            <a href="{{ route('bons-livraison.index') }}" class="btn btn-secondary mt-4">Annuler</a>
        </form>

        <script>
            // Script to collect and update the produits field
            document.querySelector('form').addEventListener('submit', function (e) {
                const produits = Array.from(document.querySelectorAll('#produit-rows tr')).map(row => {
                    const inputs = row.querySelectorAll('input');
                    return {
                        produit_id: row.cells[0].textContent.trim(),
                        quantite: parseFloat(inputs[0].value),
                        prix_unitaire_ht: parseFloat(inputs[1].value),
                        total_ligne_ht: parseFloat(row.cells[3].textContent.trim()),
                        tva: parseFloat(inputs[2].value),
                        total_ligne_ttc: parseFloat(row.cells[5].textContent.trim()),
                    };
                });

                document.getElementById('produits').value = JSON.stringify(produits);
            });


            // Add this to your existing script section
document.querySelectorAll('input[name="quantites[]"], input[name="prix_unitaire_ht[]"], input[name="tva[]"]').forEach(input => {
    input.addEventListener('change', function() {
        const row = this.closest('tr');
        const quantite = parseFloat(row.querySelector('input[name="quantites[]"]').value) || 0;
        const prixUnitaireHt = parseFloat(row.querySelector('input[name="prix_unitaire_ht[]"]').value) || 0;
        const tva = parseFloat(row.querySelector('input[name="tva[]"]').value) || 0;

        // Calculate totals
        const totalLigneHt = quantite * prixUnitaireHt;
        const totalLigneTtc = totalLigneHt * (1 + (tva / 100));

        // Update the display
        row.cells[3].textContent = totalLigneHt.toFixed(2);
        row.cells[5].textContent = totalLigneTtc.toFixed(2);
    });
});
        </script>
    </div>
</x-base>