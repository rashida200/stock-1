<x-base>
    @section('title', 'Commandes')

    <div class="table-responsive small">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
            <a class="btn btn-primary" href="{{ route('commandes.create') }}"><i class="fas fa-plus"></i> Ajouter Commande</a>
            @endif
            <form action="{{ route('commandes.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Rechercher par référence ou client" value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary me-2">Rechercher</button>
                <a href="{{ route('commandes.index') }}" class="btn btn-outline-secondary">Reset</a>
            </form>
        </div>

        <table class="table table-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Référence</th>
                    <th scope="col">Date Commande</th>
                    <th scope="col">Client</th>
                    <th scope="col">Statut</th>
                   <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($commandes->isEmpty())
                    <tr>
                        <td colspan="6">Aucune commande trouvée.</td>
                    </tr>
                @else
                    @foreach ($commandes as $commande)
                        <tr>
                            <td>{{ $commande->id }}</td>
                            <td>{{ $commande->date_commande }}</td>
                            <td>{{ $commande->client->nom }}</td> <!-- Assurez-vous que le client a un attribut 'nom' -->
                            <td>{{ $commande->statut }}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-1">

                                     @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
                                     <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-sm btn-success">
                                        modifier
                                     </a>

                                     @endif

                                    {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#detailsModal-{{ $commande->id }}">
                                        <i class="fas fa-search-plus"></i>
                                    </button> --}}
                                    <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-search-plus"></i>
                                     </a>
                                </div>
                            </td>
                        </tr>
                        <!-- Modale pour afficher les détails de la commande -->

                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span>
                Affichage de {{ $commandes->firstItem() }} à {{ $commandes->lastItem() }} sur {{ $commandes->total() }}
                entrées
            </span>
            <div class="d-flex justify-content-center">
                {{ $commandes->appends(['search' => $search])->links() }}
            </div>
            {{ $commandes->links() }}
        </div>
    </div>




</x-base>
