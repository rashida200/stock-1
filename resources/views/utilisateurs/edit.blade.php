<div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{ route('utilisateurs.update', $user->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel-{{ $user->id }}">Modifier l'utilisateur</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="name" class="form-label">Nom</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                  </div>
                  <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                  </div>
                  <div class="mb-3">
                      <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                      <input type="password" class="form-control" id="password" name="password">
                  </div>
                  <div class="mb-3">
                      <label for="type" class="form-label">Role</label>
                      <select class="form-control" id="type" name="type" required>
                          <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                          <option value="manager" {{ $user->type === 'manager' ? 'selected' : '' }}>Manager</option>
                          <option value="commercial" {{ $user->type === 'commercial' ? 'selected' : '' }}>Commercial</option>
                      </select>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
              </div>
          </form>
      </div>
  </div>
</div>