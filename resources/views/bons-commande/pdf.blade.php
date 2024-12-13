<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Bon de Commande</h1>
    <p><strong>N° BC:</strong> {{ $bonCommande->numero_bc }}</p>
    <p><strong>Fournisseur:</strong> {{ $bonCommande->fournisseur->nom }}</p>
    <p><strong>Date:</strong> {{ $bonCommande->date_commande }}</p>

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Prix HT</th>
                <th>TVA (%)</th> <!-- Added column for TVA -->
                <th>Total HT</th>
                <th>Total TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bonCommande->details as $detail)
                <tr>
                    <td>{{ $detail->reference_produit }}</td>
                    <td>{{ $detail->produit->designation ?? 'N/A' }}</td> <!-- Display the product's designation -->
                    <td>{{ $detail->quantite }}</td>
                    <td>{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                    <td>{{ number_format($detail->tva, 2) }}%</td> <!-- Display the TVA value -->
                    <td>{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
                    <td>{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right"><strong>Total HT:</strong> {{ number_format($bonCommande->total_ht, 2) }} DH</p>
    <p class="text-right"><strong>Total TTC:</strong> {{ number_format($bonCommande->total_ttc, 2) }} DH</p>
</body>
</html>
