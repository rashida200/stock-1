<!-- resources/views/devis/index.blade.php -->

<x-base>
    <div class="container">
        <h1>Liste des Devis</h1>
        <a href="{{ route('devis.create') }}" class="btn btn-primary mb-3">
            Nouveau Devis
        </a>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Actions</th>
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
                                <td>
                                    <a href="{{ route('devis.edit', $devi->id) }}" class="btn btn-sm btn-success">
                                        Modifier
                                    </a>

                                    <a href="{{ route('devis.print', $devi->id) }}" class="btn btn-sm btn-success"
                                        target="_blank">
                                        Imprimer PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $devis->links() }}
            </div>
        </div>
    </div>
</x-base>
