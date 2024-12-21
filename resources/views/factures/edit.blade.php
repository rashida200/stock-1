<x-base>
    <div class="container mt-4">
        <h1>Modifier la Facture {{ $facture->numero_facture }}</h1>

        <form action="{{ route('factures.update', $facture) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" id="client_id" class="form-control" required>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ $facture->client_id == $client->id ? 'selected' : '' }}>
                                            {{ $client->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_facture">Date Facture</label>
                                <input type="date" name="date_facture" id="date_facture"
                                    class="form-control" required
                                    value="{{ $facture->date_facture }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5>Bons de Livraison</h5>
                    <div id="bons-livraison-container">
                        @foreach($availableBonsLivraison as $bon)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox"
                                    name="bons_livraison[]"
                                    value="{{ $bon->id }}"
                                    id="bl_{{ $bon->id }}"
                                    {{ in_array($bon->id, $facture->bonsLivraison->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="bl_{{ $bon->id }}">
                                    {{ $bon->numero_bl }} - Date: {{ $bon->date_livraison }} -
                                    Total TTC: {{ number_format($bon->total_ttc, 2) }} DH
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Mettre à jour la Facture</button>
                <a href="{{ route('factures.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-base>
