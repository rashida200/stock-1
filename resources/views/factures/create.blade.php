<x-base>
    <div class="container mt-4">
        <h1>Créer une Facture</h1>

        <form action="{{ route('factures.store') }}" method="POST">
            @csrf

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" id="client_id" class="form-control" required onchange="loadBonsLivraison()">
                                    <option value="">Sélectionner un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_facture">Date Facture</label>
                                <input type="date" name="date_facture" id="date_facture" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5>Bons de Livraison</h5>
                    <div id="bons-livraison-container">
                        <!-- Will be populated via JavaScript -->
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Créer la Facture</button>
        </form>
    </div>

    <script>
        const bonsLivraison = @json($bonsLivraison);

        function loadBonsLivraison() {
            const clientId = document.getElementById('client_id').value;
            const container = document.getElementById('bons-livraison-container');
            container.innerHTML = '';

            if (clientId && bonsLivraison[clientId]) {
                const bons = bonsLivraison[clientId];
                bons.forEach(bon => {
                    container.innerHTML += `
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="bons_livraison[]"
                                value="${bon.id}" id="bl_${bon.id}">
                            <label class="form-check-label" for="bl_${bon.id}">
                                ${bon.numero_bl} - Date: ${bon.date_livraison} -
                                Total TTC: ${new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(bon.total_ttc)} DH
                            </label>
                        </div>
                    `;
                });
            } else {
                container.innerHTML = '<p class="text-muted">Aucun bon de livraison disponible pour ce client.</p>';
            }
        }
    </script>
</x-base>
