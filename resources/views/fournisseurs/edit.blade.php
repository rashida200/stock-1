@foreach ($fournisseurs as $fournisseur)
<div class="modal fade" id="editModal-{{ $fournisseur->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.fournisseurs.update', $fournisseur->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Fournisseur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ $fournisseur->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="lice" class="form-label">License</label>
                        <input type="text" class="form-control" id="lice" name="lice" value="{{ $fournisseur->lice }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $fournisseur->telephone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $fournisseur->adresse }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $fournisseur->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="rib" class="form-label">RIB</label>
                        <input type="text" class="form-control" id="rib" name="rib" value="{{ $fournisseur->rib }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
