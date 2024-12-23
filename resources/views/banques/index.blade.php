<x-base>
<div class="container">
    <h1>Liste des Banques</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (auth()->user()->type === 'admin')
    <a href="{{ route('banques.create') }}" class="btn btn-primary mb-3">Ajouter une nouvelle banque</a>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>RIB</th>
                <th>Solde</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banques as $banque)
                <tr>
                    <td>{{ $banque->id }}</td>
                    <td>{{ $banque->nom }}</td>
                    <td>{{ $banque->adresse }}</td>
                    <td>{{ $banque->rib }}</td>
                    <td>{{ $banque->solde }}</td>
                    <td>
                        <a href="{{ route('banques.show', $banque->id) }}" class="btn btn-info">Voir</a>
                        @if (auth()->user()->type === 'admin')
                        <a href="{{ route('banques.edit', $banque->id) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('banques.destroy', $banque->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette banque ?')">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-base>
