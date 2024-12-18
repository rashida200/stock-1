<x-base>
    <div class="container">
        <h1>Modifier le Bon de Livraison</h1>

        <form action="{{ route('bons-livraison.update', $bonLivraison->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ $bonLivraison->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col">
                    <label>Date de Vente</label>
                    <input type="date" name="date_vente" value="{{ $bonLivraison->date_vente }}" class="form-control" />
                </div>
                <div class="col">
                    <label>Date de Livraison</label>
                    <input type="date" name="date_livraison" value="{{ $bonLivraison->date_livraison }}"
                        class="form-control" />
                </div>
            </div>

            <hr>

            <h5>Détails du Bon</h5>
            <div id="details">
                @foreach ($bonLivraison->details as $index => $detail)
                    <div class="row mb-2">
                        <div class="col">
                            <label>Référence Produit</label>
                            <input type="text" name="references[]" value="{{ $detail->reference_produit }}"
                                class="form-control">
                        </div>
                        <div class="col">
                            <label>Quantité</label>
                            <input type="number" name="quantites[]" value="{{ $detail->quantite }}" class="form-control">
                        </div>
                        <div class="col">
                            <label>Prix HT</label>
                            <input type="number" step="0.01" name="prix_unitaire_ht[]" value="{{ $detail->prix_unitaire_ht }}"
                                class="form-control">
                        </div>
                        <div class="col">
                            <label>TVA (%)</label>
                            <input type="number" step="0.01" name="tva[]" value="{{ $detail->tva }}" class="form-control">
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">Modifier</button>
            <a href="{{ route('bons-livraison.index') }}" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>
</x-base>
