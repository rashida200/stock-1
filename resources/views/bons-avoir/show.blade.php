<!-- resources/views/bons-avoir/show.blade.php -->
<x-base>
    <div class="container mt-4">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="mb-0">
                    Détails du Bon d'Avoir
                    <span class="badge bg-{{ $bonAvoir->statut === 'en_attente' ? 'warning' : ($bonAvoir->statut === 'facturé' ? 'success' : 'info') }}">
                        {{ ucfirst($bonAvoir->statut) }}
                    </span>
                </h1>
                <div>
                    <a href="{{ route('bons-avoir.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    @if($bonAvoir->statut === 'en_attente')
                        <a href="{{ route('factures-avoir.create', ['bon_avoir' => $bonAvoir->id]) }}"
                           class="btn btn-primary me-2">
                            <i class="fas fa-file-invoice"></i> Créer Facture d'Avoir
                        </a>
                    @endif
                    <a href="{{ route('bons-avoir.print', $bonAvoir) }}"
                       class="btn btn-success"
                       target="_blank">
                        <i class="fas fa-print"></i> Imprimer
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <!-- Informations Générales -->
                    <div class="col-md-6">
                        <h4>Informations Générales</h4>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">N° Bon d'Avoir:</th>
                                <td>{{ $bonAvoir->numero_ba }}</td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ \Carbon\Carbon::parse($bonAvoir->date_avoir)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Statut:</th>
                                <td>
                                    <span class="badge bg-{{ $bonAvoir->statut === 'en_attente' ? 'warning' : ($bonAvoir->statut === 'facturé' ? 'success' : 'info') }}">
                                        {{ ucfirst($bonAvoir->statut) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Motif:</th>
                                <td>{{ $bonAvoir->motif }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Informations Client -->
                    <div class="col-md-6">
                        <h4>Informations Client</h4>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Client:</th>
                                <td>{{ $bonAvoir->client->nom }}</td>
                            </tr>
                            <tr>
                                <th>Adresse:</th>
                                <td>{{ $bonAvoir->client->adresse }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone:</th>
                                <td>{{ $bonAvoir->client->telephone }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $bonAvoir->client->email ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Informations Bon de Livraison -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h4>Bon de Livraison Associé</h4>
                        <table class="table table-sm">
                            <tr>
                                <th width="20%">N° Bon de Livraison:</th>
                                <td>{{ $bonAvoir->bonLivraison->numero_bl }}</td>
                                <th width="20%">Date Livraison:</th>
                                <td>{{ \Carbon\Carbon::parse($bonAvoir->bonLivraison->date_livraison)->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Détails des Produits -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h4>Détails des Produits Retournés</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Produit</th>
                                        <th class="text-end">Quantité</th>
                                        <th class="text-end">Prix Unitaire HT</th>
                                        <th class="text-end">TVA</th>
                                        <th class="text-end">Total HT</th>
                                        <th class="text-end">Total TTC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bonAvoir->details as $detail)
                                        <tr>
                                            <td>{{ $detail->produit->reference }}</td>
                                            <td>{{ $detail->produit->designation }}</td>
                                            <td class="text-end">{{ $detail->quantite }}</td>
                                            <td class="text-end">{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                                            <td class="text-end">{{ $detail->tva }}%</td>
                                            <td class="text-end">{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
                                            <td class="text-end">{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <td colspan="5" class="text-end"><strong>Totaux:</strong></td>
                                        <td class="text-end"><strong>{{ number_format($bonAvoir->total_ht, 2) }} DH</strong></td>
                                        <td class="text-end"><strong>{{ number_format($bonAvoir->total_ttc, 2) }} DH</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Facture d'Avoir Associée -->
                @if($bonAvoir->factureAvoir)
                    <div class="row">
                        <div class="col-12">
                            <h4>Facture d'Avoir Associée</h4>
                            <table class="table table-sm">
                                <tr>
                                    <th width="20%">N° Facture d'Avoir:</th>
                                    <td>{{ $bonAvoir->factureAvoir->numero_facture_avoir }}</td>
                                    <th width="20%">Date Facture:</th>
                                    <td>{{ \Carbon\Carbon::parse($bonAvoir->factureAvoir->date_facture)->format('d/m/Y') }}</td>
                                    <th width="20%">
                                        <a href="{{ route('factures-avoir.show', $bonAvoir->factureAvoir->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Voir la Facture
                                        </a>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-base>
