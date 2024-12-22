<x-base>
    <div class="container">
        <h1>Liste des Factures</h1>
        <a href="{{ route('factures.create') }}" class="btn btn-primary mb-3">
            Nouvelle Facture
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Client</th>
                            <th>Date Facture</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($factures as $facture)
                            <tr>
                                <td>{{ $facture->numero_facture }}</td>
                                <td>{{ $facture->client->nom }}</td>
                                <td>{{ $facture->date_facture }}</td>
                                <td>{{ number_format($facture->total_ht, 2) }} DH</td>
                                <td>{{ number_format($facture->total_ttc, 2) }} DH</td>
                                <td>{{ $facture->statut }}</td>
                                <td>
                                    @if (auth()->user()->type === 'admin')
                                    <a href="{{ route('factures.edit', $facture) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    @endif
                                    <a href="{{ route('factures.print', $facture) }}" class="btn btn-sm btn-success" target="_blank">
                                        Imprimer PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $factures->links() }}
            </div>
        </div>
    </div>
</x-base>
