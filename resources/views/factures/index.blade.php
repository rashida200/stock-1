<x-base>
    @section('title', 'Facture')
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    @endif
    <div class="container">
        <h1>Liste des Factures</h1>
     @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
     <a href="{{ route('factures.create') }}" class="btn btn-primary mb-3">
        Nouvelle Facture
    </a>
     @endif

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
                            @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')
                            <th>Actions</th>
                            @endif
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
                                    <a href="{{ route('factures.edit', $facture) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                   @if  (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')
                                   <a href="{{ route('factures.print', $facture) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <a href="{{ route('factures.printlogo', $facture) }}" class="btn btn-sm" style="background-color: #ccc; color: #000;" target="_blank">
                                    <i class="fa fa-images"></i>
                                </a>

                                   @endif
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
