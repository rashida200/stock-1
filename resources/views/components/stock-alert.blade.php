@props(['produits'])

@foreach ($produits as $produit)
    @php
        $stockLevel = $produit->quantite_initial > 0
            ? ($produit->quantity / $produit->quantite_initial) * 100
            : 0; // Default to 0% if initial_quantity is invalid
    @endphp

    @if ($produit->quantite_initial <= 0)  <!-- Fixe la condition ici -->
        <div class="alert alert-danger">
            <strong>Erreur:</strong> La quantité initiale pour <strong>{{ $produit->designation }}</strong> est nulle ou non définie.
        </div>
    @elseif ($stockLevel <= 20)
        <div class="alert alert-danger">
            <strong>Avertissement!</strong> Le stock pour <strong>{{ $produit->designation }}</strong> est à {{ round($stockLevel) }}%. Réapprovisionnez bientôt!
        </div>
    @elseif ($stockLevel <= 50)
        <div class="alert alert-warning">
            <strong>Avis:</strong> Le stock pour <strong>{{ $produit->designation }}</strong> est à {{ round($stockLevel) }}%. Pensez à vous réapprovisionner.
        </div>
    @endif
@endforeach
