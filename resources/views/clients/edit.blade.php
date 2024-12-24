@foreach ($clients as $client)
<div class="modal fade" id="editModal-{{ $client->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ $client->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="personne" {{ $client->type == 'personne' ? 'selected' : '' }}>Personne</option>
                            <option value="entreprise" {{ $client->type == 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" class="form-control" id="cin" name="cin" value="{{ $client->cin }}">
                    </div>
                    <div class="mb-3">
                        <label for="lice" class="form-label">ICE</label>
                        <input type="text" class="form-control" id="lice" name="lice" value="{{ $client->lice }}">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $client->telephone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $client->adresse }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse_projet" class="form-label">Adresse de Projet</label>
                        <input type="text" class="form-control" id="adresse_projet" name="adresse_projet" value="{{ $client->adresse_projet }}">
                    </div>
                    <div class="mb-3">
                        <label for="nombre_hectare" class="form-label">Nombre d'Hectares</label>
                        <input type="number" class="form-control" id="nombre_hectare" name="nombre_hectare" value="{{ $client->nombre_hectare }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
