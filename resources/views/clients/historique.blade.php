<x-base>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Historique de {{ $client->nom }}</h1>

        <div class="row">
            <!-- Carte des Devis -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Devis</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($devis as $devi)
                                <li class="list-group-item">
                                    <strong>Devis N°: {{ $devi->id }}</strong><br>
                                    <span>Date: {{ $devi->date_devis }}</span><br>
                                    <span>Total TTC: {{ $devi->total_ttc }} DH</span><br>
                                    <span>Statut: {{ $devi->statut }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Aucun devis trouvé.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Carte des Bons de Livraison -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Bons de Livraison</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($bonsLivraison as $bon)
                                <li class="list-group-item">
                                    <strong>Bon Livraison N°: {{ $bon->numero_bl }}</strong><br>
                                    <span>Date de Vente: {{ $bon->date_vente }}</span><br>
                                    <span>Date de Livraison: {{ $bon->date_livraison }}</span><br>
                                    <span>Total TTC: {{ $bon->total_ttc }} DH</span><br>
                                    <span>Statut: {{ $bon->statut }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Aucun bon de livraison trouvé.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Carte des Factures -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white text-center">
                        <h4>Factures</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($factures as $facture)
                                <li class="list-group-item">
                                    <strong>Facture N°: {{ $facture->numero_facture }}</strong><br>
                                    <span>Date de Facture: {{ $facture->date_facture }}</span><br>
                                    <span>Total TTC: {{ $facture->total_ttc }} DH</span><br>
                                    <span>Statut: {{ $facture->statut }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Aucune facture trouvée.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-base>
