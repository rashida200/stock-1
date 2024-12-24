<x-base>
    @section('title', 'Bon de commande')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Liste des Bons de Commande</h1>
        @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
        <a href="{{ route('bons-commande.create') }}" class="btn btn-primary mb-3">
            Nouveau Bon de Commande
        </a>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>N° BC</th>
                            <th>Fournisseur</th>
                            <th>Date</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Statut</th>
                            @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')

                            <th>Actions</th>
                            @endif
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
                                <td>{{ $bc->statut }}</td>
                                @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')
                                <td>
                                    <a href="{{ route('bons-commande.edit', $bc->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="{{ route('bons-commande.print', $bc) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('bons-commande.printlogo', $bc) }}" class="btn btn-sm " style="background-color: #ccc; color: #000;"
                                        target="_blank">
                                        <i class="fa-regular fa-images"></i></a>


                                </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bonsCommande->links() }}
            </div>
        </div>
    </div>
</x-base>
