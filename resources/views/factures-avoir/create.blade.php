<!-- resources/views/factures-avoir/create.blade.php -->
<x-base>
    <div class="container mt-4">
        <h1>Créer une Facture d'Avoir</h1>

        <div class="card mb-4">
            <div class="card-body">
                @if ($bonAvoir)
                    <h4>Détails du Bon d'Avoir</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>N° Bon d'Avoir:</strong> {{ $bonAvoir->numero_ba }}</p>
                            <p><strong>Client:</strong> {{ $bonAvoir->client->nom }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Date Avoir:</strong> {{ $bonAvoir->date_avoir }}</p>
                            <p><strong>Total TTC:</strong> {{ number_format($bonAvoir->total_ttc, 2) }} DH</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Bon de Livraison:</strong> {{ $bonAvoir->bonLivraison->numero_bl }}</p>
                            <p><strong>Total BL TTC:</strong> {{ number_format($bonAvoir->bonLivraison->total_ttc, 2) }} DH</p>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Montant à rembourser:</strong>
                        {{ number_format($bonAvoir->total_ttc, 2) }} DH
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('factures-avoir.store') }}" method="POST">
            @csrf

            @if ($bonAvoir)
                <input type="hidden" name="bon_avoir_id" value="{{ $bonAvoir->id }}">
            @else
                <div class="form-group mb-3">
                    <label for="bon_avoir_id">Sélectionner un Bon d'Avoir:</label>
                    <select name="bon_avoir_id" id="bon_avoir_id" class="form-control" required>
                        <option value="">Sélectionnez un bon d'avoir</option>
                        @foreach($bonsAvoir as $ba)
                            <option value="{{ $ba->id }}">
                                {{ $ba->numero_ba }} - {{ $ba->client->nom }} - {{ number_format($ba->total_ttc, 2) }} DH
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group mb-3">
                <label for="date_facture">Date Facture:</label>
                <input type="date" name="date_facture" id="date_facture" class="form-control"
                       value="{{ date('Y-m-d') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Créer la Facture d'Avoir</button>
        </form>
    </div>
</x-base>
