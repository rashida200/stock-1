<!-- resources/views/factures-avoir/show.blade.php -->
<x-base>
    <div class="container mt-4">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Détails de la Facture d'Avoir</h1>
                <a href="{{ route('factures-avoir.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card-body">
                @if($factureAvoir)
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Informations de la Facture</h4>
                            <table class="table table-sm">
                                <tr>
                                    <th>N° Facture:</th>
                                    <td>{{ $factureAvoir->numero_facture_avoir }}</td>
                                </tr>
                                <tr>
                                    <th>Date Facture:</th>
                                    <td>
                                        @if($factureAvoir->date_facture)
                                            {{ \Carbon\Carbon::parse($factureAvoir->date_facture)->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>N° Bon d'Avoir:</th>
                                    <td>{{ $factureAvoir->bonAvoir->numero_ba ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Rest of your view remains the same -->

                    </div>
                @else
                    <div class="alert alert-danger">
                        La facture d'avoir n'a pas été trouvée.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-base>
