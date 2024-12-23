<!-- bons-avoir/create.blade.php -->
<x-base>
    <div class="container mt-4">
        <h1>Créer un Bon d'Avoir</h1>

        <form action="{{ route('bons-avoir.store') }}" method="POST" id="bonAvoirForm">
            @csrf

            <div class="form-group">
                <label for="bon_livraison">Bon de Livraison:</label>
                <select name="bon_livraison_id" id="bon_livraison" class="form-control" required onchange="loadBonLivraisonDetails()">
                    <option value="">Sélectionnez un bon de livraison</option>
                    @foreach ($bonsLivraison as $bl)
                        <option value="{{ $bl->id }}"
                            data-client-id="{{ $bl->client_id }}"
                            data-details="{{ json_encode($bl->details) }}">
                            {{ $bl->numero_bl }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="date_avoir">Date d'Avoir:</label>
                <input type="date" name="date_avoir" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label for="motif">Motif:</label>
                <textarea name="motif" class="form-control" required></textarea>
            </div>

            <input type="hidden" name="client_id" id="client_id">

            <div class="card mt-4">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité Livrée</th>
                                <th>Quantité à Retourner</th>
                                <th>Prix Unitaire HT</th>
                                <th>TVA</th>
                                <th>Total HT</th>
                                <th>Total TTC</th>
                            </tr>
                        </thead>
                        <tbody id="productsTable"></tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Créer le Bon d'Avoir</button>
        </form>
    </div>

    <script>
    function loadBonLivraisonDetails() {
        const select = document.getElementById('bon_livraison');
        const option = select.options[select.selectedIndex];

        if (!option.value) return;

        const clientId = option.dataset.clientId;
        const details = JSON.parse(option.dataset.details);

        document.getElementById('client_id').value = clientId;

        const tbody = document.getElementById('productsTable');
        tbody.innerHTML = '';

        details.forEach(detail => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${detail.produit.designation}</td>
                <td>${detail.quantite}</td>
                <td>
                    <input type="number" name="produits[${detail.produit_id}][quantite]"
                           class="form-control" min="1" max="${detail.quantite}"
                           onchange="calculateTotals(this)">
                    <input type="hidden" name="produits[${detail.produit_id}][produit_id]"
                           value="${detail.produit_id}">
                    <input type="hidden" name="produits[${detail.produit_id}][prix_unitaire_ht]"
                           value="${detail.prix_unitaire_ht}">
                    <input type="hidden" name="produits[${detail.produit_id}][tva]"
                           value="${detail.tva}">
                </td>
                <td>${detail.prix_unitaire_ht}</td>
                <td>${detail.tva}%</td>
                <td class="total-ht">0.00</td>
                <td class="total-ttc">0.00</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function calculateTotals(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(input.value) || 0;
    const prixUnitaireHt = parseFloat(row.cells[3].textContent);
    const tva = parseFloat(row.cells[4].textContent);

    const totalHt = quantity * prixUnitaireHt;
    const totalTtc = totalHt * (1 + (tva / 100));

    row.querySelector('.total-ht').textContent = totalHt.toFixed(2);
    row.querySelector('.total-ttc').textContent = totalTtc.toFixed(2);

    // Make sure hidden fields are updated
    const produitId = row.querySelector('input[name$="[produit_id]"]').value;
    row.querySelector(`input[name="produits[${produitId}][prix_unitaire_ht]"]`).value = prixUnitaireHt;
    row.querySelector(`input[name="produits[${produitId}][tva]"]`).value = tva;
}
    </script>
</x-base>
