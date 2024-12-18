<x-base>
    <div class="card">
        <div class="card-header">
            <h4>Détails de la Commande</h4>
        </div>
        <div class="card-body">
            <!-- Informations sur commandes -->
            <div class="mb-3">
                <h5>Informations sur la Commande</h5>
                <p><strong>Référence :</strong> {{ $commande->formatId() }}</p>
                <p><strong>Statut :</strong> {{ $commande->statut }}</p>
                <p><strong>Montant Total :</strong> {{ number_format($commande->montant_total, 2) }} MAD</p>
            </div>
            <hr>
            <!-- Informations sur le client -->
            <div class="mb-3">
                <h5>Informations sur le Client</h5>
                <p><strong>Nom :</strong> {{ $commande->client->nom }}</p>
                <p><strong>Date de la Commande :</strong> {{ $commande->date_commande }}</p>
                <p><strong>Règlement :</strong> {{ $commande->reglement ?? 'Non précisé' }}</p>
            </div>
            <hr>
            <!-- Liste des Produits -->
            <div class="mb-3">
                <h5>Produits Associés</h5>
                <div class="row">
                    @forelse ($commande->produits as $produit)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $produit->designation ?? 'N/A' }}</h6>
                                    <p><strong>Quantité :</strong> {{ $produit->pivot->qte_vte ?? 0 }}</p>
                                    <p><strong>Prix Unitaire :</strong> {{ $produit->pivot->prix_unitaire ?? 0 }} MAD</p>
                                    <p><strong>TVA :</strong> {{ $produit->pivot->tva ?? 0 }}%</p>
                                    <p><strong>Montant TTC :</strong> {{ $produit->pivot->montant_ttc ?? 0 }} MAD</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Aucun produit associé à cette commande.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
</x-base>