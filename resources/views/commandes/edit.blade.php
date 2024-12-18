<x-base>
    <div class="container">
        <h1>Modifier le Bon de Commande</h1>

        <form action="{{ route('commandes.update', $commandeClient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Affichage des erreurs -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Client -->
            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <option value="">Choisir un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ $commandeClient->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date de commande -->
            <div class="mb-3">
                <label>Date de commande</label>
                <input type="date" name="date_commande" class="form-control"
                       value="{{ $commandeClient->date_commande }}" required>
            </div>

            <!-- Règlement -->
            <div class="mb-3">
                <label for="reglement" class="form-label">Règlement</label>
                <select class="form-control" id="reglement" name="reglement" required>
                    @foreach (['Espèce', 'Chèque', 'LCTraite', 'Virement', 'Prélèvement', 'En Compte', 'Délégation de créance'] as $type)
                        <option value="{{ $type }}" {{ $commandeClient->reglement == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Référence du règlement -->
            <div class="mb-3">
                <label for="ref_regl" class="form-label">Référence Règlement</label>
                <input type="text" class="form-control" id="ref_regl" name="ref_regl" 
                       value="{{ $commandeClient->ref_regl }}">
            </div>

            <!-- Produits -->
            <div class="mb-3">
                <label class="form-label">Produits</label>
                <table class="table table-bordered" id="produitsTable">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Remise</th>
                            <th>TVA (%)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commandeClient->produits as $produit)
                        <tr>
                            <td>
                                <select class="form-control produit_id" name="produit_id[]" required>
                                    @foreach ($produits as $p)
                                        <option value="{{ $p->id }}" {{ $produit->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->designation }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="qte_vte[]" 
                                       value="{{ $produit->pivot->qte_vte }}" min="1" required>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="prix_unitaire[]" 
                                       value="{{ $produit->pivot->prix_unitaire }}" min="0" step="0.01" required>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="remise[]" 
                                       value="{{ $produit->pivot->remise }}" min="0" step="0.01">
                            </td>
                            <td>
                                <select class="form-control" name="tva[]">
                                    <option value="7" {{ $produit->pivot->tva == '7' ? 'selected' : '' }}>7%</option>
                                    <option value="10" {{ $produit->pivot->tva == '10' ? 'selected' : '' }}>10%</option>
                                    <option value="20" {{ $produit->pivot->tva == '20' ? 'selected' : '' }}>20%</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow">Supprimer</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="addRow">Ajouter un produit</button>
            </div>

            <!-- Statut -->
            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-control" id="statut" name="statut" required>
                    @foreach (['en attente', 'expediée', 'livree', 'annulee'] as $status)
                        <option value="{{ $status }}" {{ $commandeClient->statut == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour la commande</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const produitsTable = document.getElementById('produitsTable');
        const addRowBtn = document.getElementById('addRow');

        // Add new row
        addRowBtn.addEventListener('click', function() {
            const tbody = produitsTable.querySelector('tbody');
            const newRow = `
                <tr>
                    <td>
                        <select class="form-control produit_id" name="produit_id[]" required>
                            <option value="">Choisir un produit</option>
                            @foreach ($produits as $produit)
                                <option value="{{ $produit->id }}">{{ $produit->designation }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control" name="qte_vte[]" min="1" required></td>
                    <td><input type="number" class="form-control" name="prix_unitaire[]" min="0" step="0.01" required></td>
                    <td><input type="number" class="form-control" name="remise[]" min="0" step="0.01"></td>
                    <td>
                        <select class="form-control" name="tva[]">
                            <option value="7">7%</option>
                            <option value="10">10%</option>
                            <option value="20">20%</option>
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Supprimer</button></td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', newRow);
        });

        // Remove row
        produitsTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                const tbody = produitsTable.querySelector('tbody');
                if (tbody.children.length > 1) {
                    e.target.closest('tr').remove();
                } else {
                    alert('Vous devez garder au moins un produit dans la commande.');
                }
            }
        });
    });
    </script>
</x-base>