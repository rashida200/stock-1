<x-base>
<div class="container">
    <h1>Détails de la banque</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $banque->nom }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Nom de la banque:</strong> {{ $banque->nom }}</p>
            <p><strong>Adresse:</strong> {{ $banque->adresse }}</p>
            <p><strong>RIB:</strong> {{ $banque->rib }}</p>
            <p><strong>SOLDE:</strong> {{ $banque->solde }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('banques.index') }}" class="btn btn-primary">Retour à la liste</a>
            </form>
        </div>
    </div>
</div>

</x-base>
