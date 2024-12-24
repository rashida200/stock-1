<x-base>
    @section('title', 'Devis')
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    @endif
    <div class="container">
        <h1>Liste des Devis</h1>
        @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
        <a href="{{ route('devis.create') }}" class="btn btn-primary mb-3">
            Nouveau Devis
        </a>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-center">
                    <thead >
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')

                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devis as $devi)
                            <tr>
                                <td>{{ $devi->id }}</td>
                                <td>{{ $devi->client->nom }}</td>
                                <td>{{ $devi->date_devis }}</td>
                                <td>{{$devi->statut}}</td>
                                <td>{{ number_format($devi->total_ht, 2) }} DH</td>
                                <td>{{ number_format($devi->total_ttc, 2) }} DH</td>
                                @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')
                                <td>
                                    <a href="{{ route('devis.edit', $devi->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="{{ route('devis.print', $devi->id) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a href="{{ route('devis.printlogo', $devi->id) }}" class="btn btn-sm" style="background-color: #ccc; color: #000;"
                                        target="_blank">
                                        <i class="fa fa-images"></i>
                                    </a>
                                </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $devis->links() }}
            </div>
        </div>
    </div>
</x-base>
