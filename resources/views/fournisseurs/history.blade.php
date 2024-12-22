<x-base>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Historique de {{ $fournisseur->nom }}</h1>

        <div class="row">
            <!-- Bons de Commande -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white text-center">
                        <h4>Bons de Commande</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($bonsCommande as $bon)
                                <li class="list-group-item">
                                    <strong>Bon N°: {{ $bon->numero_bc }}</strong><br>
                                    <span>Date de Commande: {{ $bon->date_commande }}</span><br>
                                    <span>Montant Total: {{ $bon->total_ttc }} DH</span><br>
                                    <span>Statut: {{ $bon->statut }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Aucun bon de commande trouvé.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
    </x-base>
