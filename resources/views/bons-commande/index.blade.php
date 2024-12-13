<x-base>

    <div class="container">
        <h1>Liste des Bons de Commande</h1>
        <a href="{{ route('bons-commande.create') }}" class="btn btn-primary mb-3">
            Nouveau Bon de Commande
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>N° BC</th>
                            <th>Fournisseur</th>
                            <th>Date</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonsCommande as $bc)
                            <tr>
                                <td>{{ $bc->numero_bc }}</td>
                                <td>{{ $bc->fournisseur->nom }}</td>
                                <td>{{ $bc->date_commande }}</td>
                                <td>{{ number_format($bc->total_ht, 2) }} DH</td>
                                <td>{{ number_format($bc->total_ttc, 2) }} DH</td>
                                <td>
                                    <a href="{{ route('bons-commande.print', $bc) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        Imprimer PDF
                                    </a>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bonsCommande->links() }}
            </div>
        </div>
    </div>


</x-base>
