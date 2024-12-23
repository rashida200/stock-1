<x-base>
<div class="container">
    {{-- Vous pouvez modifier le style de la carte ici --}}
    <div class="card">
        <div class="card-header">
            <h3>Paramètres d'impression</h3>
        </div>

        <div class="card-body">
            {{-- Message de succès - Vous pouvez modifier le style de l'alerte --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('identifiants.save') }}" method="POST">
                @csrf

                {{-- Section des informations générales --}}
                <div class="row">
                    {{-- Vous pouvez ajuster les colonnes (col-md-6) selon vos besoins --}}
                    <div class="col-md-6 mb-3">
                        <label for="company_name">Nom de l'entreprise</label>
                        <input type="text"
                               class="form-control @error('company_name') is-invalid @enderror"
                               name="company_name"
                               value="{{ old('company_name', $identification->company_name) }}"
                               required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="location">Lieu Ou Ville</label>
                        <input type="text"
                               class="form-control @error('location') is-invalid @enderror"
                               name="location"
                               value="{{ old('location', $identification->location) }}"
                               required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address">Adresse</label>
                        <input type="text"
                               class="form-control @error('address') is-invalid @enderror"
                               name="address"
                               value="{{ old('address', $identification->address) }}"
                               required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email', $identification->email) }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone1">Telephone 1</label>
                        <input type="text"
                               class="form-control @error('phone1') is-invalid @enderror"
                               name="phone1"
                               value="{{ old('phone1', $identification->phone1) }}"
                               required>
                        @error('phone1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone2">Telephone 2</label>
                        <input type="text"
                               class="form-control @error('phone2') is-invalid @enderror"
                               name="phone2"
                               value="{{ old('phone2', $identification->phone2) }}"
                               required>
                        @error('phone2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ice">ICE</label>
                        <input type="text"
                               class="form-control @error('ice') is-invalid @enderror"
                               name="ice"
                               value="{{ old('ice', $identification->ice) }}"
                               required>
                        @error('ice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="if">I.F</label>
                        <input type="text"
                               class="form-control @error('if') is-invalid @enderror"
                               name="if"
                               value="{{ old('if', $identification->if) }}"
                               required>
                        @error('if')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rc">R.C</label>
                        <input type="text"
                               class="form-control @error('rc') is-invalid @enderror"
                               name="rc"
                               value="{{ old('rc', $identification->rc) }}"
                               required>
                        @error('rc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="patente">Patente</label>
                        <input type="text"
                               class="form-control @error('patente') is-invalid @enderror"
                               name="patente"
                               value="{{ old('patente', $identification->patente) }}"
                               required>
                        @error('patente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cnss">CNSS</label>
                        <input type="text"
                               class="form-control @error('cnss') is-invalid @enderror"
                               name="cnss"
                               value="{{ old('cnss', $identification->cnss) }}"
                               required>
                        @error('cnss')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Vous pouvez réorganiser ou modifier les champs selon vos besoins --}}
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="company_description">Description de l'entreprise</label>
                        <textarea class="form-control @error('company_description') is-invalid @enderror"
                                  name="company_description"
                                  rows="3"
                                  required>{{ old('company_description', $identification->company_description) }}</textarea>
                        @error('company_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <!-- Vue blade : identifiants/index.blade.php -->
                    <label for="banque_id">Informations Bancaires</label>
                    <select name="banque_id"
                            class="form-control @error('banque_id') is-invalid @enderror"
                            required>
                        <option value="">Sélectionner une banque</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ (old('banque_id', $identification->banque_id) == $bank->id) ? 'selected' : '' }}>
                                Compte N°: {{ $bank->rib }} | {{ $bank->nom }} | {{ $bank->adresse }}
                            </option>
                        @endforeach
                    </select>
                        @error('banque_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Autres champs du formulaire --}}
                {{-- ... Ajoutez vos autres champs ici ... --}}

                {{-- Section du bouton de sauvegarde --}}
                {{-- Vous pouvez modifier le style du bouton ou ajouter d'autres boutons --}}

                @if (auth()->user()->type === 'admin')
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            {{-- Exemple d'un bouton d'annulation --}}
                            {{-- <a href="{{ route('dashboard') }}" class="btn btn-secondary">Annuler</a> --}}
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

{{-- Vous pouvez ajouter du CSS personnalisé ici --}}
<style>
    /* Exemple de personnalisation du select */
    select[name="bank_id"] {
        padding: 10px;
        font-size: 14px;
    }

    /* Exemple de personnalisation des options */
    select[name="bank_id"] option {
        padding: 8px;
        white-space: pre-wrap;
    }

    /* Ajoutez vos styles personnalisés ici */
</style>

</x-base>
