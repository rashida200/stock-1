
<!-- bons-avoir/index.blade.php -->
<x-base>
    <div class="container">
        <h1>Liste des Bons d'Avoir</h1>

        @if (auth()->user()->type === 'admin' || auth()->user()->type === 'commercial')
        <a href="{{ route('bons-avoir.create') }}" class="btn btn-primary mb-3">
            Nouveau Bon d'Avoir
        </a>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>N° BA</th>
                            <th>N° BL</th>
                            <th>Client</th>
                            <th>Date d'Avoir</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonsAvoir as $ba)
                            <tr>
                                <td>{{ $ba->numero_ba }}</td>
                                <td>{{ $ba->bonLivraison->numero_bl }}</td>
                                <td>{{ $ba->client->nom }}</td>
                                <td>{{ $ba->date_avoir }}</td>
                                <td>{{ number_format($ba->total_ht, 2) }} DH</td>
                                <td>{{ number_format($ba->total_ttc, 2) }} DH</td>
                                <td>
                                    <span class="badge {{ $ba->statut === 'validé' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $ba->statut }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('bons-avoir.show', $ba) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('bons-avoir.print', $ba) }}" class="btn btn-sm btn-success" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if($ba->statut === 'en_attente')
                                        <a href="{{ route('factures-avoir.create', ['bon_avoir' => $ba->id]) }}"
                                           class="btn btn-sm btn-primary">
                                            Créer Facture
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bonsAvoir->links() }}
            </div>
        </div>
    </div>
</x-base>
