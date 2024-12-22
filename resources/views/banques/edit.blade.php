<x-base>
<div class="container">
    <h1>Modifier la banque</h1>

    <form action="{{ route('banques.update', $banque->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom de la banque</label>
            <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $banque->nom) }}" required>
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse', $banque->adresse) }}" required>
            @error('adresse')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="rib">RIB</label>
            <input type="text" name="rib" id="rib" class="form-control @error('rib') is-invalid @enderror" value="{{ old('rib', $banque->rib) }}" required>
            @error('rib')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="text" name="solde" id="solde" class="form-control @error('solde') is-invalid @enderror" value="{{ old('solde', $banque->solde) }}" required>
            @error('total')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Mettre à jour</button>
    </form>

    <a href="{{ route('banques.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
</x-base>
