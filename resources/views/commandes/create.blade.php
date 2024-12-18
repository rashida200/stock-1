{{-- <x-base>
    <form action="{{ route('commandes.store') }}" method="POST">
        @csrf

            <h5  >Ajouter une Commande Client</h5>
           
        <div class="form-control">

            <!-- Client -->
            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <option value="">Choisir un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date de Commande -->
            <div class="mb-3">
                <div class="form-group">
                    <label>Date de commande</label>
                    <input type="date" name="date_commande" class="form-control @error('date_commande') is-invalid @enderror"
                           value="{{ old('date_commande', date('Y-m-d')) }}" required>
                    @error('date_commande')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Règlement -->
            <div class="mb-3">
                <label for="reglement" class="form-label">Règlement</label>
                <select class="form-control" id="reglement" name="reglement" required>
                    <option value="">Choisir un type de règlement</option>
                    <option value="Espèce">Espèce</option>
                    <option value="Chèque">Chèque</option>
                    <option value="LCTraite">LC Traite</option>
                    <option value="Virement">Virement</option>
                    <option value="Prélèvement">Prélèvement</option>
                    <option value="En Compte">En Compte</option>
                    <option value="Délégation de créance">Délégation de créance</option>
                </select>
            </div>

            <!-- Référence Réglement -->
            <div class="mb-3">
                <label for="ref_regl" class="form-label">Référence Règlement</label>
                <input type="text" class="form-control" id="ref_regl" name="ref_regl" placeholder="Saisir la référence du règlement (optionnel)">
            </div>

            <!-- Produits Ajoutés -->
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
                        <tr>
                            <td>
                                <select class="form-control produit_id" name="produit_id[]" required>
                                    <option value="">Choisir un produit</option>
                                    @foreach ($produits as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->designation }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control qte_vte" name="qte_vte[]" min="1" required>
                            </td>
                            <td>
                                <input type="number" class="form-control prix_unitaire" name="prix_unitaire[]" min="0" step="0.01" required>
                            </td>
                            <td>
                                <input type="number" class="form-control remise" name="remise[]" min="0" step="0.01">
                            </td>
                            <td>
                                <select class="form-control tva" name="tva[]" required>
                                    <option value="7">7%</option>
                                    <option value="10">10%</option>
                                    <option value="20">20%</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" id="addRow">Ajouter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Statut de Commande -->
            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-control" id="statut" name="statut" required>
                    <option value="en attente">En attente</option>
                    <option value="expediée">Expédiée</option>
                    <option value="livree">Livrée</option>
                    <option value="annulee">Annulée</option>
                </select>
            </div>
        </div>

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Créer la commande</button>
    </form>
    <script>
        document.getElementById("produitsTable").addEventListener("click", function (event) {
            if (event.target.id === "addRow") {
                event.preventDefault(); // Prevent form submission
    
                const tableBody = event.target.closest("table").querySelector("tbody");
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
                        <td>
                            <input type="number" class="form-control qte_vte" name="qte_vte[]" min="1" required>
                        </td>
                        <td>
                            <input type="number" class="form-control prix_unitaire" name="prix_unitaire[]" min="0" step="0.01" required>
                        </td>
                        <td>
                            <input type="number" class="form-control remise" name="remise[]" min="0" step="0.01">
                        </td>
                        <td>
                            <select class="form-control tva" name="tva[]" required>
                                <option value="7">7%</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow">Supprimer</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML("beforeend", newRow);
            }
    
            if (event.target.classList.contains("removeRow")) {
                event.target.closest("tr").remove();
            }
        });
    </script>
</x-base> --}}
<x-base>
    <form action="{{ route('commandes.store') }}" method="POST">
        @csrf
        <h5>Ajouter une Commande Client</h5>

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
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date de commande -->
        <div class="mb-3">
            <label>Date de commande</label>
            <input type="date" name="date_commande" class="form-control @error('date_commande') is-invalid @enderror"
                   value="{{ old('date_commande', date('Y-m-d')) }}" required>
        </div>

        <!-- Règlement -->
        <div class="mb-3">
            <label for="reglement" class="form-label">Règlement</label>
            <select class="form-control" id="reglement" name="reglement" required>
                <option value="">Choisir un type de règlement</option>
                @foreach (['Espèce', 'Chèque', 'LCTraite', 'Virement', 'Prélèvement', 'En Compte', 'Délégation de créance'] as $type)
                    <option value="{{ $type }}" {{ old('reglement') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Référence du règlement -->
        <div class="mb-3">
            <label for="ref_regl" class="form-label">Référence Règlement</label>
            <input type="text" class="form-control" id="ref_regl" name="ref_regl" value="{{ old('ref_regl') }}">
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
                        <td>
                            <button type="button" class="btn btn-success btn-sm" id="addRow">Ajouter</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Statut -->
        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-control" id="statut" name="statut" required>
                <option value="en attente">En attente</option>
                <option value="expediée">Expédiée</option>
                <option value="livree">Livrée</option>
                <option value="annulee">Annulée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer la commande</button>
    </form>
    <script>
        document.getElementById("produitsTable").addEventListener("click", function (event) {
    if (event.target.id === "addRow") {
        event.preventDefault();
        const tableBody = event.target.closest("table").querySelector("tbody");
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
        tableBody.insertAdjacentHTML("beforeend", newRow);
    }

    if (event.target.classList.contains("removeRow")) {
        event.target.closest("tr").remove();
    }
});

    </script>
</x-base>
