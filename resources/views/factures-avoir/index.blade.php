<!-- resources/views/factures-avoir/index.blade.php -->
<x-base>
    <div class="container mt-4">
        <h1>Liste des Factures d'Avoir</h1>

        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>N° BA</th>
                            <th>Client</th>
                            <th>Date Facture</th>
                            <th>Montant Original</th>
                            <th>Montant Avoir</th>
                            <th>Montant Final</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facturesAvoir as $facture)
                            <tr>
                                <td>{{ $facture->numero_facture_avoir }}</td>
                                <td>{{ $facture->bonAvoir->numero_ba }}</td>
                                <td>{{ $facture->bonAvoir->client->nom }}</td>
                                <td>{{ $facture->date_facture }}</td>
                                <td>{{ number_format($facture->montant_original_ttc, 2) }} DH</td>
                                <td>{{ number_format($facture->montant_avoir_ttc, 2) }} DH</td>
                                <td>{{ number_format($facture->montant_final_ttc, 2) }} DH</td>
                                <td>
                                    <a href="{{ route('factures-avoir.show', $facture) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('factures-avoir.print', $facture) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $facturesAvoir->links() }}
            </div>
        </div>
    </div>
</x-base>
