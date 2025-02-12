<x-base>
    @section('title', 'Bon de livraison')
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    @endif
    </div>
    <div class="container">
        <h1>Liste des Bons de Livraison</h1>
        @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
        <a href="{{ route('bons-livraison.create') }}" class="btn btn-primary mb-3">
            Nouveau Bon de Livraison
        </a>
        @endif
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
                            @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')

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
                                @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
                                <td>
                                    <a href="{{ route('bons-livraison.edit', $bl->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('bons-livraison.print', $bl) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('bons-livraison.printlogo', $bl) }}" class="btn btn-sm"
                                    target="_blank" style="background-color: #ccc; color: #000;">
                                        <i class="fa fa-images"></i>
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
