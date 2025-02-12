<x-base>
    @section('title', 'Utilisateurs')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive small">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (auth()->user()->type === 'admin')
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> Ajouter un utilisateur
                </button>
            @endif
            <form action="{{ route('utilisateurs.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Chercher par Nom ou Email"
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary">Chercher</button>
                <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline-secondary">Retour</a>
            </form>
        </div>
        @include('utilisateurs.create')
        @foreach ($users as $user)
            @include('utilisateurs.edit', ['user' => $user])
        @endforeach
        <table class="table table-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Role</th>
                    @if (auth()->user()->type === 'admin')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="4">Aucun Utilisateur trouvé.</td>
                    </tr>
                @else
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->type }}</td>
                            @if (auth()->user()->type === 'admin')
                                <td class="align-middle">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit" title="Supprimer">
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
                Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }}
                entrées
            </span>
            <div class="d-flex justify-content-center">
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        </div>

    </div>



</x-base>
