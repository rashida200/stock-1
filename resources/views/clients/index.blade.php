<x-base>
    @section('title', 'Clients')
    <div class="table-responsive small">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Ajouter Client
            </button>
            <form action="{{ route('clients.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Rechercher par nom ou référence" value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary me-2">Rechercher</button>
                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Reset</a>
            </form>
        </div>

        <table class="table table-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Type</th>
                    <th scope="col">CIN</th>
                    <th scope="col">LICE</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Adresse de projet</th>
                    <th scope="col">Nombre d'hectares</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($clients->isEmpty())
                    <tr>
                        <td colspan="9">Aucun client trouvé.</td>
                    </tr>
                @else
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->type }}</td>
                            <td>{{ $client->cin ?? 'Non renseigné' }}</td>
                            <td>{{ $client->lice ?? 'Non renseigné' }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>{{ $client->adresse }}</td>
                            <td>{{ $client->adresse_projet ?? $client->adresse }}</td>
                            <td>{{ $client->nombre_hectare ?? 'Non renseigné' }}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-1">

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $client->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <a href="{{ route('clients.historique', $client) }}" class="btn btn-primary btn-sm" title="Historique"><i class="fas fa-history"></i></a>


                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span>
                Affichage de {{ $clients->firstItem() }} à {{ $clients->lastItem() }} sur {{ $clients->total() }}
                entrées
            </span>
            <div class="d-flex justify-content-center">
                {{ $clients->appends(['search' => $search])->links() }}
            </div>
        </div>

    </div>

    <!-- Create Modal -->
    @include('clients.create')
    @include('clients.edit')

</x-base>
