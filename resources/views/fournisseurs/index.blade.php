<x-base>
    @section('title', 'Fournisseurs')
    @if  (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="table-responsive small">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (auth()->user()->type === 'admin' ||auth()->user()->type === 'commercial')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Ajouter un fournisseur
            </button>
            @endif
            <form action="{{ route('admin.fournisseurs') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par Nom ou ICE"
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary">Rechercher</button>
                <a href="{{ route('admin.fournisseurs') }}" class="btn btn-outline-secondary">Retour</a>
            </form>
        </div>

        <table class="table table-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">License</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Email</th>
                    <th scope="col">RIB</th>
                    @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')

                    <th scope="col">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($fournisseurs->isEmpty())
                    <tr>
                        <td colspan="8">Aucun Fournisseur trouvé.</td>
                    </tr>
                @else
                    @foreach ($fournisseurs as $fournisseur)
                        <tr>
                            <td>{{ $fournisseur->id }}</td>
                            <td>{{ $fournisseur->nom }}</td>
                            <td>{{ $fournisseur->lice }}</td>
                            <td>{{ $fournisseur->telephone }}</td>
                            <td>{{ $fournisseur->adresse }}</td>
                            <td>{{ $fournisseur->email }}</td>
                            <td>{{ $fournisseur->rib }}</td>
                            @if (auth()->user()->type === 'admin'||auth()->user()->type === 'commercial')
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-1">

                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $fournisseur->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <a href="{{ route('fournisseurs.history', $fournisseur) }}" class="btn btn-primary btn-sm" title="Historique"><i class="fas fa-history"></i></a>
                                    <form action="{{ route('admin.fournisseurs.destroy', $fournisseur->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>


                                </div>
                            </td>
                            @endif

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span>
                Showing {{ $fournisseurs->firstItem() }} to {{ $fournisseurs->lastItem() }}
                of {{ $fournisseurs->total() }} entries
            </span>
            <div class="d-flex justify-content-center">
                {{ $fournisseurs->links() }}
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    @include('fournisseurs.create')
    @include('fournisseurs.edit')

</x-base>
