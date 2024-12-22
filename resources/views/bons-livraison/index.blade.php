<x-base>

    <div class="container">
        <h1>Liste des Bons de Livraison</h1>
        <a href="{{ route('bons-livraison.create') }}" class="btn btn-primary mb-3">
            Nouveau Bon de Livraison
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>N° BL</th>
                            <th>Client</th>
                            <th>Date de Vente</th>
                            <th>Date de Livraison</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            @if (auth()->user()->type === 'admin')

                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonsLivraison as $bl)
                            <tr>
                                <td>{{ $bl->numero_bl }}</td>
                                <td>{{ $bl->client->nom }}</td>
                                <td>{{ $bl->date_vente }}</td>
                                <td>{{ $bl->date_livraison }}</td>
                                <td>{{ number_format($bl->total_ht, 2) }} DH</td>
                                <td>{{ number_format($bl->total_ttc, 2) }} DH</td>
                                @if (auth()->user()->type === 'admin')
                                <td>
                                    <a href="{{ route('bons-livraison.edit', $bl->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="{{ route('bons-livraison.print', $bl) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        Imprimer PDF
                                    </a>


                                </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bonsLivraison->links() }}
            </div>
        </div>
    </div>


</x-base>
