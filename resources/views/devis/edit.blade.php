<x-base>
    <div class="container">
        <h1>Editer un Devis</h1>

        <form action="{{ route('devis.update', $devis->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $client->id == $devis->client_id ? 'selected' : '' }}>{{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date_devis">Date du Devis</label>
                            <input type="date" name="date_devis" id="date_devis" class="form-control" value="{{ old('date_devis', $devis->date_devis) }}" required>
                        </div>
                    </div>

                    <h3>Produits</h3>
                    <div id="produits-container">
                        @foreach($devis->details as $detail)
                            <div class="produit-ligne mb-3 d-flex align-items-center">
                                <select name="references[]" class="form-control me-2" required>
                                    <option value="">Sélectionner un produit</option>
                                    @foreach($produits as $produit)
                                        <option value="{{ $produit->reference }}" {{ $produit->reference == $detail->produit->reference ? 'selected' : '' }}>{{ $produit->reference }} - {{ $produit->designation }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="quantites[]" class="form-control me-2" placeholder="Quantité" value="{{ old('quantites.' . $loop->index, $detail->quantite) }}" required min="1">
                                <input type="number" step="0.01" name="prix_unitaire_ht[]" class="form-control me-2" placeholder="Prix Unitaire HT" value="{{ old('prix_unitaire_ht.' . $loop->index, $detail->prix_unitaire_ht) }}" required>
                                <select name="tva[]" class="form-control me-2" required>
                                    <option value="7" {{ $detail->tva == 7 ? 'selected' : '' }}>7%</option>
                                    <option value="10" {{ $detail->tva == 10 ? 'selected' : '' }}>10%</option>
                                    <option value="20" {{ $detail->tva == 20 ? 'selected' : '' }}>20%</option>
                                </select>
                                <button type="button" class="btn btn-danger btn-supprimer-produit">Supprimer</button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary" id="btn-ajouter-produit">Ajouter un produit</button>

                    <button type="submit" class="btn btn-primary mt-4">Mettre à jour le devis</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const produitsContainer = document.getElementById('produits-container');
            const btnAjouterProduit = document.getElementById('btn-ajouter-produit');

            btnAjouterProduit.addEventListener('click', function() {
                const ligneTemplate = produitsContainer.querySelector('.produit-ligne').cloneNode(true);

                // Reset values of cloned row
                ligneTemplate.querySelectorAll('input, select').forEach(input => {
                    input.value = '';
                });

                produitsContainer.appendChild(ligneTemplate);
            });

            produitsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-supprimer-produit')) {
                    e.target.closest('.produit-ligne').remove();
                }
            });
        });
    </script>
    @endpush
</x-base>
