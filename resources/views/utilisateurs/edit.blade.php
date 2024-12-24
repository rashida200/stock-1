@foreach ($users as $user)
<div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('utilisateurs.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $user->id }}">Modifier utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name-{{ $user->id }}" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name-{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email-{{ $user->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email-{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="type-{{ $user->id }}" class="form-label">Role</label>
                        <select class="form-control" id="type-{{ $user->id }}" name="type" required>
                            <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ $user->type == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="commercial" {{ $user->type == 'commercial' ? 'selected' : '' }}>Commercial</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
